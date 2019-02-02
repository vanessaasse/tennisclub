<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\EventRepository;
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
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArticleRepository $articleRepository,EventRepository $eventRepository, ObjectManager
    $em)
    {
        $this->articleRepository = $articleRepository;
        $this->eventRepository = $eventRepository;
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
        $listEvents = $this->eventRepository->getFiveNextEvents();

        return $this->render('frontEnd/index.html.twig', array(
            'listArticles' => $listArticles,
            'listEvents' => $listEvents
        ));
    }

}