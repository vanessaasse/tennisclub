<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Route("/{slug}-{id}", name="page.index", requirements={"slug": "[a-z0-9/-]*"})
     * @return Response
     */
    public function index(Page $page, string $slug):Response
    {
        if($page->getSlug() !== $slug)
        {
            return $this->redirectToRoute('page.index', [
                'slug' => $page->getSlug(),
                'id' => $page->getId()
            ], 301);
        }

        return $this->render('frontEnd/page/index.html.twig', [
            'page' => $page
        ]);


    }



}