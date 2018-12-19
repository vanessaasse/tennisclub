<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @ParamConverter("page", class="App\Entity\Page")
     * @param Page $page
     * @param string $slug
     *
     * @return Response
     */
    public function show(Page $page, string $slug):Response
    {
        if($page->getIsPublished() === true)
        {
            if($page->getSlug() !== $slug)
            {
                return $this->redirectToRoute('page.show', [
                    'slug' => $page->getSlug()
                ], 301);
            }

            return $this->render('frontEnd/page/show.html.twig', [
                'page' => $page
            ]);
        }

        return $this->redirectToRoute('homepage');
        $this->addFlash('alert', "La page recherchée n'existe pas.");
        // TODO Suis-je obligée de mettre "page" dans la route ?





    }



}