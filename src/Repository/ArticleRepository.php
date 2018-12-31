<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     *
     * @return mixed
     */
    public function getPublishedArticles()
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->getQuery()
            ->getResult();

        return $query;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findPreviousArticle($id)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.id < :id')
            ->setParameter('id', $id)
            ->orderBy('a.id', 'DESC')
            ->andWhere('a.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query;
    }



    public function findNextArticle($id)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.id > :id')
            ->setParameter('id', $id)
            ->orderBy('a.id', 'ASC')
            ->andWhere('a.isPublished = :isPublished')
            ->setParameter('isPublished', '1')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $query;
    }
}
