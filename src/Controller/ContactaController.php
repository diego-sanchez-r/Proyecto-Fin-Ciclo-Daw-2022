<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \App\Entity\Contacta;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class ContactaController extends AbstractController
{
    #[Route('/contacta', name: 'app_contacta')]
    public function index(): Response
    {
        return $this->render('contacta/index.html.twig', [
            'controller_name' => 'ContactaController',
        ]);
    }
    
    
    
    /**
     * @Route("/contacta/nuevo", name="add_contacta")
    */
    public function insertar(Request $request, ManagerRegistry $doctrine): Response {
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        $contacto = new Contacta();
      if ($request->isMethod('POST')) {
            $motivo = $request->request->get('motivo');
            $descripcion = $request->request->get('descripcion');
            $contacto->setMotivo($motivo);
            $contacto->setDescripcion($descripcion);
            $contacto->setUsuario($this->getUser());
            $contacto->setFechaCreacion(new \DateTime());
            $em = $doctrine->getManager();
            $em->persist($contacto);
            $em->flush();
            
            $this->addFlash("aviso", "Mensaje Enviado");
            return $this->redirectToRoute("inicio");
        }
    }
    
}
