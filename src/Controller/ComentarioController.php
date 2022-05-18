<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Comentario;
use App\Entity\Usuario;
use App\Entity\Incidencia;
use Symfony\Component\HttpFoundation\JsonResponse;

class ComentarioController extends AbstractController
{
    #[Route('/comentario', name: 'app_comentario')]
    public function index(): Response
    {
        return $this->render('comentario/index.html.twig', [
            'controller_name' => 'ComentarioController',
        ]);
    }
    
    /**
     * @Route("/comentario/nuevo", name="add_comentario")
    */
    public function insertar(Request $request, ManagerRegistry $doctrine): Response {
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        $comentario = new Comentario();
      if ($request->isMethod('POST')) {
            $texto = $request->request->get('texto');
            $id_incidencia = $request->request->get('id_inci');
            $repositorio3 = $doctrine->getRepository(Incidencia::class);
            $inciComentario = $repositorio3->find($id_incidencia);
            $comentario->setTexto($texto);
            $comentario->setIncidencia($inciComentario);
            $comentario->setUsuario($this->getUser());
            $comentario->setFechaCreacion(new \DateTime());
            $em = $doctrine->getManager();
            $em->persist($comentario);
            $em->flush();
            
            $this->addFlash("aviso", "Incidencia Insertada");
            return $this->redirectToRoute("app_incidencia");
        }
    }
    
    /**
     * @Route("/comentario/nuevoAjax",options={"expose"=true}, name="add_comentario_ajax")
    */
    public function comentar(Request $request,ManagerRegistry $doctrine): Response {
        if($request->isXmlHttpRequest()){
            $comentario2 = new Comentario();
            $id_inciden = $request->request->get( key: 'id');
            $texto_ajax = $request->request->get( key: 'texto');
            $repositorio3 = $doctrine->getRepository(Incidencia::class);
            $inciajax = $repositorio3->find($id_inciden);
            $comentario2->setTexto($texto_ajax);
            $comentario2->setIncidencia($inciajax);
            $comentario2->setUsuario($this->getUser());
            $comentario2->setFechaCreacion(new \DateTime());
            $usuario = $this->getUser();
            $em = $doctrine->getManager();
            $em->persist($comentario2);
            $em->flush();
           
            return new JsonResponse(['comentario'=> $comentario2->getTexto(),'usuarioNombre'=> $usuario->getNombre(),'usuarioapellidos'=> $usuario->getApellidos()]);
        }
    }
    
    
}
