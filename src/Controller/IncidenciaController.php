<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Incidencia;
use App\Entity\TipoAveria;
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
    
    /**
     * @Route("/incidencia/nueva", name="add_incidencia")
     */
    public function insertar(Request $request, ManagerRegistry $doctrine): Response {
      if ($request->isMethod('POST')) {
            //Los datos del formulario
            $titulo = $request->request->get('titulo');
            $descripcion = $request->request->get('descripcion');
            $codigo = $request->request->get('codigo');
            $gravedad = $request->request->get('gravedad');
            $imagen = $request->request->get('imagen');
            $latitud = $request->request->get('latitud');
            $longitud = $request->request->get('longitud');
            $averia = $request->request->get('averia');
            $repositorio = $doctrine->getRepository(TipoAveria::class);
            $averia = $repositorio->find($averia);
            $incidencia = new Incidencia();
            //No las tiene que añadir el usuario
            $incidencia->setUsuario($this->getUser());
            $incidencia->setEstado("Iniciada");
            $incidencia->setFechaCreacion(new \DateTime());
            //Las que añade el usuario
            $incidencia->setTitulo($titulo);
            $incidencia->setDescripcion($descripcion);
            $incidencia->setCodigoPostal($codigo);
            $incidencia->setNivelGravedad($gravedad);
            $incidencia->setImagen($imagen);
            $incidencia->setLatitud($latitud);
            $incidencia->setLongitud($longitud);
            $incidencia->setAveria($averia);
            
            
            $em = $doctrine->getManager();
            $em->persist($incidencia);
            $em->flush();
            
            $this->addFlash("aviso", "Se creo una nueva incidencia");
            return $this->redirectToRoute("app_incidencia");
        } else {
            $repositorio2 = $doctrine->getRepository(TipoAveria::class);
            $tiposAverias = $repositorio2->findAll();
            return $this->render("incidencia/nuevaIncidencia.html.twig", [
            'tiposDeAverias' => $tiposAverias,
            ]);
        }
    }
    
    
    
    
    
    
    
    
}
