<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Noticias;
use Symfony\Component\HttpFoundation\Request;

class NoticiaController extends AbstractController
{
    #[Route('/noticia', name: 'app_noticia')]
    public function index(ManagerRegistry $doctrine): Response
    {
        
        $repositorio = $doctrine->getRepository(Noticias::class);
        $noticias = $repositorio->findBy(
           [],
           ["fechaCreacion" => "DESC"] 
           );
        return $this->render('noticia/index.html.twig', [
            'noticias' => $noticias,
        ]);
    }
    
    
    /**
     * @Route("/noticia/{id<\d+>}",name="ver_noticia")
    */
    public function ver(Noticias $noticiaver, Request $request, ManagerRegistry $doctrine): Response {
        //Comprobar si el usuario esta logeado.
            if($this->getUser() === null){
                return $this->redirectToRoute("login");
            }

        $repositorio = $doctrine->getRepository(Noticias::class);
        $id = $request->get('id');
        $noticiaver = $repositorio->find($id);

        return $this->render('noticia/verDetallesNoticia.html.twig', [
            'noticiaSeleccionada' => $noticiaver,
        ]);
    }
}
