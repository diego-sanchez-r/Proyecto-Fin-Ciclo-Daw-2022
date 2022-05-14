<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactaController extends AbstractController
{
    #[Route('/contacta', name: 'app_contacta')]
    public function index(): Response
    {
        return $this->render('contacta/index.html.twig', [
            'controller_name' => 'ContactaController',
        ]);
    }
}
