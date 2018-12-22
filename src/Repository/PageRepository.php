<?php

namespace App\Repository;

use App\Entity\Page;
use App\Entity\PageCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }


    /**
     * @param PageCategory $pageCategory
     * @return \Doctrine\ORM\QueryBuilder|mixed
     */
    public function findPageByCategory(PageCategory $pageCategory)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.id', 'ASC')
            ->leftJoin('p.pageCategory', 'c')
            ->addSelect('c');

        $query = $query->add('where', $query->expr()->in('c', ':c'))
            ->setParameter('c', $pageCategory)
            ->getQuery()
            ->getResult();

        return $query;

    }
}
