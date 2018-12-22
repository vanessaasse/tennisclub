<?php

namespace App\Controller;

use App\Entity\Page;
use App\Entity\PageCategory;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class PageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    private $pageRepositoy;

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
        $this->pageRepositoy = $pageRepository;
        $this->em = $em;
    }

    /**
     * @Route("/page/{slug}", name="page.show", requirements={"slug": "[a-z0-9/-]*"})
     *
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
     *
     * @return Response
     * @Template()
     */
    public function getMenuCategory(): Response
    {
        $em = $this->getDoctrine()->getManager();
        //$listPages = $this->pageRepositoy->findPagebyCategory($pageCategory);

        $listPages = $em->getRepository('App:Page')->findAll();


        foreach ($listPages as $page){
            $page->getSlug();
            $page->getTitle();
        }

        return $this->render('frontEnd/page/menuCategory.html.twig', array(
            'listPages' => $listPages
        ));
    }
    /**
     * @Route("/a-propos", name="ap_pros")

    public function aPropos(PageRepository $pageRepository){
        $page = $pageRepository->findOneBy(['slug'=> "test-1"]);

    }*/



}