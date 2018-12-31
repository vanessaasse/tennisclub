<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
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
     * @Route("/actualites/", name="article.list")
     *
     */
    public function index()
    {
        $this->getDoctrine()->getManager();
        $listArticles = $this->articleRepository->getPublishedArticles();

        return $this->render('frontEnd/article/index.html.twig', array(
            'listArticles' => $listArticles
        ));
    }

    /**
     * @Route("/actualites/{slug}", name="article.show", requirements={"slug": "[a-z0-9/-]*"})
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {

        if($article->getIsPublished() === false)
        {
            $this->addFlash('alert', "L'article recherché n'existe pas.");
            return $this->redirectToRoute('homepage');
        }

        return $this->render('frontEnd/article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @param $id
     * @return Response
     */
    public function getPreviousAndNextArticleLink($id): Response
    {
        $previousArticle = $this->articleRepository->findPreviousArticle($id);
        $nextArticle= $this->articleRepository->findNextArticle($id);

        return $this->render('frontEnd/article/previousAndNextArticleLink.html.twig', array(
            'previousArticle' => $previousArticle,
            'nextArticle' => $nextArticle
        ));

    }

}