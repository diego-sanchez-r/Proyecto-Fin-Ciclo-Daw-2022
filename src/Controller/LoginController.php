<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
                    'last_username' => $lastUsername,
                    'error' => $error,
        ]);
    }
    
     #[Route('/inicio', name: 'inicio')]
    public function indexInicio(): Response {
       
        return $this->render('index.html.twig');
    }
}
