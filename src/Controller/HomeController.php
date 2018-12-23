<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Page;


class HomeController extends AbstractController
{
    /**
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function index():Response
    {
        return $this->render('frontEnd/index.html.twig');
    }

}