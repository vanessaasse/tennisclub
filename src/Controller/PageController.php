<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\PageCategory;
use App\Form\ContactType;
use App\Repository\PageRepository;
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
     * @param $slug
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
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('notice', 'Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.');
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontEnd/page/contact.html.twig', array('form'=>$form->createView()));

    }



    /**
     * @Route("/a-propos", name="ap_pros")

    public function aPropos(PageRepository $pageRepository){
        $page = $pageRepository->findOneBy(['slug'=> "test-1"]);

    }*/



}