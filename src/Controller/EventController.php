<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * EventController constructor.
     * @param EventRepository $eventRepository
     * @param ObjectManager $em
     */
    public function __construct(EventRepository $eventRepository, ObjectManager $em)
    {
        $this->eventRepository = $eventRepository;
        $this->em = $em;
    }


    /**
     * @Route("/agenda/", name="event.list")
     */
    public function index(): Response
    {
        $this->getDoctrine()->getManager();
        $listEvents = $this->eventRepository->findPublishedEvents();

        return $this->render('frontEnd/event/index.html.twig', array(
            'listEvents' => $listEvents
        ));
    }


    /**
     * @Route("/agenda/{slug}", name="event.show", requirements={"slug": "[a-z0-9/-]*"})
     * @param Event $event
     * @return Response
     */
    public function show(Event $event): Response
    {
        if($event->getIsPublished() === false)
        {
            $this->addFlash('alert', "L'évènement recherché n'existe pas.");
            return $this->redirectToRoute('homepage');
        }

        return $this->render('frontEnd/event/show.html.twig', array(
            'event' => $event));
    }


}