<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Event;
use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use App\Entity\Page;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array(array('updateUserPassword')),
            'easy_admin.pre_update' => array(array('setEditedAtPage'), array('setEditedAtArticle'),
                array('setEditedAtEvent'), array('updateUserPassword'))
        );
    }

    /**
     * @param GenericEvent $event
     *
     */
    public function setEditedAtPage(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Page)) {
            return;
        }

        $entity->setEditedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

        $event['Page'] = $entity;
    }

    /**
     * @param GenericEvent $event
    */
    public function setEditedAtArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if(!($entity instanceof Article)){
            return;
        }

        $entity->setEditedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $event['Article'] = $entity;

    }

    /**
     * @param GenericEvent $event
     */
    public function setEditedAtEvent(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if(!($entity instanceof Event))
        {
            return;
        }

        $entity->setEditedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $event['Event'] = $entity;
    }


    /**
     * @param GenericEvent $event
     */
    public function updateUserPassword(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if(!($entity instanceof User && $entity->getPlainPassword()))
        {
            return;
        }

        $this->userManager->encodePassword($entity, $entity->getPlainPassword());
    }




}