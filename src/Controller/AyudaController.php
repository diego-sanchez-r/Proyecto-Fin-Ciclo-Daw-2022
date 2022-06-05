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
        //Comprobar si el usuario esta logeado.
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        return $this->render('ayuda/ayudaInciConnect.html.twig', [
            'controller_name' => 'AyudaController',
        ]);
    }
}
