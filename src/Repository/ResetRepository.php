<?php

namespace App\Repository;

use App\Entity\Reset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reset[]    findAll()
 * @method Reset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reset::class);
    }

    public function findOneByResetPassword($token)
    {
        return $this->findOneBy(array('token' => $token));
    }
}
