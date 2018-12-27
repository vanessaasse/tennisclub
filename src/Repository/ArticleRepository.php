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


    public function getPreviousArticle($id)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.id < 1')
            ->setParameter('1', $id)
            ->orderBy('a.id', 'DESC LIMIT 1')
            ->getQuery()
            ->getResult();

        return $query;
    }
}
