<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        dump($user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(array('ROLE_ADMIN'));


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            dump($user);
            $this->addFlash('success', 'Votre compte utilisateur a bien été enregistré');
            return $this->redirectToRoute('login');
            // TODO Ajout Envoi login et mot de passe par email


        }


        return $this->render('registration/register.html.twig', array('form' => $form->createView()));
    }
}
