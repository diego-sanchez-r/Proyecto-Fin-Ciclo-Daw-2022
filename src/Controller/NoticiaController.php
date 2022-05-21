<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Noticias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
    
    /**
     * @Route("/noticia/nueva", name="add_noticia")
     */
    public function insertar(Request $request, ManagerRegistry $doctrine,SluggerInterface $slugger): Response {
        $repositorio = $doctrine->getRepository(Noticias::class);
        $noticias = $repositorio->findBy(
           [],
           ["fechaCreacion" => "DESC"] 
           );
        $noticia = new Noticias();
        $form = $this->createFormBuilder($noticia)
            ->add("imagen", FileType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, elija una foto para la noticia.',
                    ]),
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Por favor, suba una imagen válida y que no sobrepase de 1Mb de tamaño.',
                    ])
                ],
                'attr' => array(
                    'class' => 'form-control',
                    'oninput'=> 'this.className=""'
                )
                
            ])
                ->getForm();
                ;
                $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
            //Los datos del formulario
            $titulo = $request->request->get('titulo');
            $descripcion = $request->request->get('descripcion');
            //No las tiene que añadir el usuario
            $noticia->setUsuario($this->getUser());
            $noticia->setFechaCreacion(new \DateTime());
            //Las que añade el usuario
            $noticia->setTitulo($titulo);
            $noticia->setDescripcion($descripcion);
             //IMAGEN
            $brochureFile = $form['imagen']->getData();
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('imagenes_ruta_noticias'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('aviso','Ha ocurrido un problema al subir la imagen');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $noticia->setImagen($newFilename);
            }
            $em = $doctrine->getManager();
            $em->persist($noticia);
            $em->flush();
            
            $this->addFlash("aviso", "Añadida nueva noticia");
            return $this->redirectToRoute("add_noticia");
        } else {
            return $this->renderForm("noticia/index.html.twig", [
                'noticias' => $noticias,
                'form_noticia'=>$form , 
            ]);
        }
    }
    
    /**
     *@Route("/noticia/borrar/{id<\d+>}",name="borrar_noticia")
     */
    public function borrar(Noticias $noticia, ManagerRegistry $doctrine): Response{
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        $em = $doctrine->getManager();
        $em->remove($noticia);
        $em->flush();
        
        $this->addFlash("aviso", "Noticia borrada");
        return $this->redirectToRoute("add_noticia");
    }
}
