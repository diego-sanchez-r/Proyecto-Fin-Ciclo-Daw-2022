<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Usuario;

class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //Comprobar si el usuario esta logeado.
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        $usuario = new Usuario();
        $usuario = $this->getUser();
        $repositorio = $doctrine->getRepository(Usuario::class);
        $usuario = $repositorio->find($usuario->getId());
        
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
            'usuarioConectado' => $usuario,
        ]);
    }
}
