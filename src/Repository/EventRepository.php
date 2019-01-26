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
        $today = date('Y/m/d');

        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->orderBy('e.beginningEventDate', 'ASC')
            ->andWhere('e.beginningEventDate >= :beginningEventDate')
            ->setParameter('beginningEventDate', $today)
            ->orWhere('e.endEventDate >= :endEventDate')
            ->setParameter('endEventDate', $today)
            ->getQuery()
            ->getResult();

        return $query;
    }

    // TODO Ajouter la notion d'évènement supérieur ou égal à aujourd'hui

    /**
     * @param $beginningEventDate
     * @return mixed
     */
    public function findPreviousEvent($beginningEventDate)
    {

        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.beginningEventDate < :beginningEventDate')
            ->setParameter('beginningEventDate', $beginningEventDate)
            ->orderBy('e.beginningEventDate', 'DESC')
            ->andWhere('e.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query;
    }


    /**
     * @param $beginningEventDate
     * @return mixed
     */
    public function findNextEvent($beginningEventDate)
    {
        $query = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.beginningEventDate > :beginningEventDate')
            ->setParameter('beginningEventDate', $beginningEventDate)
            ->orderBy('e.beginningEventDate', 'ASC')
            ->andWhere('e.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query;
    }


}
