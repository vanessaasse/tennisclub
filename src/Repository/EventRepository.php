<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return mixed
     */
    public function findPublishedEvents()
    {
        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->orderBy('e.eventDate', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }


    /**
     * @param $eventDate
     * @return mixed
     */
    public function findPreviousEvent($eventDate)
    {

        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.eventDate < :eventDate')
            ->setParameter('eventDate', $eventDate)
            ->orderBy('e.eventDate', 'DESC')
            ->andWhere('e.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query;
    }


    /**
     * @param $eventDate
     * @return mixed
     */
    public function findNextEvent($eventDate)
    {
        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.eventDate > :eventDate')
            ->setParameter('eventDate', $eventDate)
            ->orderBy('e.eventDate', 'ASC')
            ->andWhere('e.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query;
    }


}
