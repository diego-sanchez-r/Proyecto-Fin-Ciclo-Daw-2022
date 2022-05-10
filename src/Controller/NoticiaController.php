<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoticiaController extends AbstractController
{
    #[Route('/noticia', name: 'app_noticia')]
    public function index(): Response
    {
        return $this->render('noticia/index.html.twig', [
            'controller_name' => 'NoticiaController',
        ]);
    }
}
