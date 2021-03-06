<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $this->getDoctrine()->getManager();
        $listArticles = $paginator->paginate(
            $this->articleRepository->getPublishedArticles(),
            $request->query->getInt('page', 1),
            5);

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

    /**
     * @param Article $article
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function getUrl(Article $article, Request $request, $slug)
    {
        $currentRoute = $request->attributes->get('_route');
        $currentUrl = $this->get('router')->generate($currentRoute, array('slug' => $slug), true);

        return $this->render('frontEnd/article/socialmedia.html.twig', [
            'article' => $article, 'currentUrl' => $currentUrl]);
    }

}