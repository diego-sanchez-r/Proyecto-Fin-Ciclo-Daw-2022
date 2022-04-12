<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Incidencia;
use Symfony\Component\HttpFoundation\Request;

class IncidenciaController extends AbstractController
{
    #[Route('/incidencia', name: 'app_incidencia')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //Comprobar si el usuario esta logeado.
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        
        $repositorio = $doctrine->getRepository(Incidencia::class);
        $misIncidencia = $repositorio->findAll();
        
        return $this->render('incidencia/index.html.twig', [
            'controller_name' => 'IncidenciaController',
            'mis_incidencias' => $misIncidencia,
        ]);
    }
    
    
    
    /**
     * @Route("/incidencia/{id<\d+>}",name="ver_incidencia")
    */
    public function ver(Incidencia $incidenciaver, Request $request, ManagerRegistry $doctrine): Response {
        //Comprobar si el usuario esta logeado.
            if($this->getUser() === null){
                return $this->redirectToRoute("login");
            }

        $repositorio = $doctrine->getRepository(Incidencia::class);
        $id = $request->get('id');
        $incidenciaver = $repositorio->find($id);

        return $this->render('incidencia/verDetallesIncidencia.html.twig', [
            'incidenciaSeleccionada' => $incidenciaver,
        ]);
    }
    
    
    
    
    
    
    
    
}