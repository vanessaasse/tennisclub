<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Page;


class HomeController extends AbstractController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArticleRepository $articleRepository, ObjectManager $em)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }



    /**
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function index():Response
    {
        $listArticles = $this->articleRepository->getThreeFirstPublishedArticles();

        return $this->render('frontEnd/index.html.twig', array(
            'listArticles' => $listArticles
        ));
    }

}