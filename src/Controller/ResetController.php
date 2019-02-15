<?php

namespace App\Controller;


use App\Entity\Reset;
use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Manager\UserManager;
use App\Repository\ResetRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetController extends AbstractController
{

    private $resetRepository;

    private $em;


    public function __construct(ResetRepository $resetRepository, ObjectManager $em)
    {
        $this->resetRepository = $resetRepository;
        $this->em = $em;
    }

    /**
     * @Route("/forgot-password", name="forgotPassword" )
     * @param Request $request
     * @param Reset $reset
     * @param $email
     * @param EmailService $emailService
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function forgotPassword(Request $request, EmailService $emailService, EntityManagerInterface $em)
    {
        //J'appelle mon form dans lequel je saisis mon adresse pour modifier mon mot de passe
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           // Je récupère les données du formulaire
            $data = $form->getData();

            //Je vais chercher l'utilisateur dans la BDD grâce à son email saisi
            $user = $em->getRepository(User::class)->findOneByEmail($data['email']);

            if ($user) {
                /* getResetToken si user existe sinon crée un nouveau reset */
                $reset = $user->getResetToken() ?? new Reset();
                $reset->setToken(uniqid());
                $reset->setUser($user);
                $em->persist($reset);
                $em->flush();

                $emailService->sendResetPasswordMail($reset);

                $this->addFlash('notice', "Votre demande de modification de mot de passe a bien été prise en compte.
                Un mail vous a été adressé.");

                return $this->redirectToRoute('homepage', [], 301);
            }
        }
        return $this->render('reset/forgotPassword.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/reset-password/{token}", name="resetPassword", requirements={"token": "[a-z0-9/-]*"} )
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetPassword(Request $request, UserManager $userManager, Reset $reset)
    {

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $userManager->changePassword($reset->getUser(), $data['plainPassword']);

            return $this->redirectToRoute('login');
        }
        return $this->render('reset/resetPassword.html.twig', ['form' => $form->createView()]);

    }
}