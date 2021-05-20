<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    /**
     * @return Response HTTP response
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="homepage_index",
     * )
     */
    public function index(Request $request): Response
    {
        return $this->render(
            'homepage/index.html.twig',
            []
        );
    }
}