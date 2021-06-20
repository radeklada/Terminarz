<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomePageController
 */
class HomePageController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
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
