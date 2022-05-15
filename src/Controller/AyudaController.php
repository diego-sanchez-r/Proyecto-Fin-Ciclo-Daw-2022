<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AyudaController extends AbstractController
{
    #[Route('/ayuda', name: 'app_ayuda')]
    public function index(): Response
    {
        return $this->render('ayuda/ayudaInciConnect.html.twig', [
            'controller_name' => 'AyudaController',
        ]);
    }
}
