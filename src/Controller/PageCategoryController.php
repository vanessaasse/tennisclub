<?php

namespace App\Controller;

use App\Entity\PageCategory;
use App\Repository\PageCategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageCategoryController extends AbstractController
{
    /**
     * @var PageCategoryRepository
     */
    private $pageCategoryRepository;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * PageCategoryController constructor.
     * @param PageCategoryRepository $pageCategoryRepository
     * @param ObjectManager $em
     */
    public function __construct(PageCategoryRepository $pageCategoryRepository, ObjectManager $em)
    {
        $this->pageCategoryRepository = $pageCategoryRepository;
        $this->em = $em;
    }


    /**
     * @Route("/categorie/{slug}", name="pageCategory.show", requirements={"slug": "[a-z0-9/-]*"})
     * @param PageCategory $pageCategory
     * @return Response
     */
    public function show(PageCategory $pageCategory): Response
    {
        return $this->render('frontEnd/pageCategory/show.html.twig', array(
            'pageCategory' => $pageCategory)
        );

    }
}