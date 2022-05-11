<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Noticias;

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
}
