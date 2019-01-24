<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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


    /**
     * @param $eventDate
     * @return Response
     */
    public function getPreviousAndNextEventLink($eventDate): Response
    {
        $previousEvent = $this->eventRepository->findPreviousEvent($eventDate);
        $nextEvent= $this->eventRepository->findNextEvent($eventDate);

        return $this->render('frontEnd/event/previousAndNextEventLink.html.twig', array(
            'previousEvent' => $previousEvent,
            'nextEvent' => $nextEvent
        ));
    }

    /**
     * @param Event $event
     * @param Request $request
     * @param $slug
     * @return Response
     */
    public function getUrl(Event $event, Request $request, $slug)
    {
        $currentRoute = $request->attributes->get('_route');
        $currentUrl = $this->get('router')->generate($currentRoute, array('slug' => $slug), true);

        return $this->render('frontEnd/event/socialmedia.html.twig', [
            'event' => $event, 'currentUrl' => $currentUrl]);
    }


}