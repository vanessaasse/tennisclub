<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\PageCategory;
use App\Form\ContactType;
use App\Form\EnrolmentTennisSchool;
use App\Form\ReservationTennisCourt;
use App\Repository\PageRepository;
use App\Service\EmailService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class PageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var ObjectManager
     */
    private $em;


    /**
     * PageController constructor.
     * @param PageRepository $pageRepository
     * @param ObjectManager $em
     */
    public function __construct(PageRepository $pageRepository, ObjectManager $em)
    {
        $this->pageRepository = $pageRepository;
        $this->em = $em;
    }


    /**
     * @Route("/page/{slug}", name="page.show", requirements={"slug": "[a-z0-9/-]*"})
     * @param Page $page
     * @return Response
     */
    public function show(Page $page): Response
    {
        if($page->getIsPublished() === false)
        {
            $this->addFlash('alert', "La page recherchée n'existe pas.");
            return $this->redirectToRoute('homepage');
        }

        return $this->render('frontEnd/page/show.html.twig', [
            'page' => $page
        ]);
    }
    // TODO penser à créer les pages d'erreur


    /**
     * @return Response
     */
    public function getMenuCategory($pageCategory): Response
    {
        $this->getDoctrine()->getManager();
        $listPages = $this->pageRepository->findPageByCategory($pageCategory);

        return $this->render('frontEnd/page/menuCategory.html.twig', array(
            'listPages' => $listPages
        ));
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param EmailService $emailService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contact(Request $request, EmailService $emailService)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $emailService->sendMailContact($form->getData());

            $this->addFlash('notice', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontEnd/page/contact.html.twig', array('form'=>$form->createView()));

    }


    /**
     * @Route("/reserver-un-court", name="reservation-court")
     * @param Request $request
     * @param EmailService $emailService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function reservationTennisCourt(Request $request, EmailService $emailService)
    {
        $form = $this->createForm(ReservationTennisCourt::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $emailService->sendMailReservationTennisCourt($form->getData());

            $this->addFlash('notice', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontEnd/page/reservationTennisCourt.html.twig', array('form'=>$form->createView()));
    }


    /**
     * @Route("/page/{slug}", name="tarifs-et-inscription", requirements={"slug": "tarifs-et-inscription"})
     * @param Page $page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function enrolmentTennisSchool(Page $page, Request $request)
    {
        $form = $this->createForm(EnrolmentTennisSchool::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('notice', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontEnd/page/enrolmentTennisSchool.html.twig', array('form'=>$form->createView(), 'page' => $page));
    }








    /**
     * @Route("/page/{slug}", name="liens-utiles", requirements={"slug": "liens-utiles"})
     * @param Page $page
     * @param Request $request
     * @param EmailService $emailService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function liensUtiles(Page $page, Request $request, EmailService $emailService)
    {
        $form = $this->createForm(ReservationTennisCourt::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $emailService->sendMailReservationTennisCourt($form->getData());

            $this->addFlash('notice', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontEnd/page/show.html.twig', array('form'=>$form->createView(), 'page' => $page));
    }

    /**
     * @Route("/a-propos", name="ap_pros")

    public function aPropos(PageRepository $pageRepository){

        $this->getDoctrine()->getManager();

        $page = $pageRepository->findOneBy(['slug'=> "liens-utiles"]);

        return $this->render('frontEnd/page/show.html.twig', [
            'page' => $page
        ]);

    } */



}