<?php

namespace App\Manager;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;

class ArticleManager
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * ArticleManager constructor.
     * @param ArticleRepository $articleRepository
     * @param EntityManager $em
     */
    public function __construct(ArticleRepository $articleRepository, EntityManager $em)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }

}