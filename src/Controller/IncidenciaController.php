<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Incidencia;
use App\Entity\Comentario;
use App\Entity\TipoAveria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IncidenciaController extends AbstractController
{
    #[Route('/incidencia', name: 'app_incidencia')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        //Comprobar si el usuario esta logeado.
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        $usuario = $this->getUser();
        $repositorio = $doctrine->getRepository(Incidencia::class);
        $misIncidencia = $repositorio->findBy(
           ["codigoPostal" => $usuario->getCodigo()],
           ["fechaCreacion" => "DESC"] 
           );
        
        
        return $this->renderForm('incidencia/index.html.twig', [
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
     * @Route("/incidencias/marcadores",name="ver_marcadores")
    */
    public function verMarcador(Request $request, ManagerRegistry $doctrine): Response {
        //Comprobar si el usuario esta logeado.
            if($this->getUser() === null){
                return $this->redirectToRoute("login");
            }

        $repositorio = $doctrine->getRepository(Incidencia::class);
        $misIncidencia = $repositorio->findBy(
           [],     
           ["fechaCreacion" => "DESC"] 
           );
        
        
        return $this->renderForm('incidencia/todasLasIncidenciasMarcador.html.twig', [
            'controller_name' => 'IncidenciaController',
            'mis_incidencias' => $misIncidencia,
        ]);
    }
    
    /**
     * @Route("/incidencia/nueva", name="add_incidencia")
     */
    public function insertar(Request $request, ManagerRegistry $doctrine,SluggerInterface $slugger): Response {
        $incidencia = new Incidencia();
        $form = $this->createFormBuilder($incidencia)
            ->add("imagen", FileType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, elija una foto de perfil.',
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
            $codigo = $request->request->get('codigo');
//            $imagen = $request->request->get('imagen')->getData();
            $gravedad = $request->request->get('gravedad');
            $latitud = $request->request->get('latitud');
            $longitud = $request->request->get('longitud');
            $averia = $request->request->get('averia');
            $repositorio = $doctrine->getRepository(TipoAveria::class);
            $averia = $repositorio->find($averia);
            //No las tiene que añadir el usuario
            $incidencia->setUsuario($this->getUser());
            $incidencia->setEstado("Iniciada");
            $incidencia->setFechaCreacion(new \DateTime());
            //Las que añade el usuario
            $incidencia->setTitulo($titulo);
            $incidencia->setDescripcion($descripcion);
            $incidencia->setCodigoPostal($codigo);
            $incidencia->setNivelGravedad($gravedad);
            $incidencia->setLatitud($latitud);
            $incidencia->setLongitud($longitud);
            $incidencia->setAveria($averia);
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
                        $this->getParameter('imagenes_ruta_incidencia'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('aviso','Ha ocurrido un problema al subir la imagen');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $incidencia->setImagen($newFilename);
            }
            $em = $doctrine->getManager();
            $em->persist($incidencia);
            $em->flush();
            
            $this->addFlash("aviso", "Se creo una nueva incidencia");
            return $this->redirectToRoute("app_incidencia");
        } else {
            $repositorio2 = $doctrine->getRepository(TipoAveria::class);
            $tiposAverias = $repositorio2->findAll();
            return $this->renderForm("incidencia/nuevaIncidencia.html.twig", [
            'tiposDeAverias' => $tiposAverias,'form_incidencia'=>$form
            ]);
        }
    }
    
     /**
     * @Route("/MisIncidenciasNotificadas", name="app_incidenciaMias")
     */
    public function verMisIncidencias(ManagerRegistry $doctrine): Response
    {
        //Comprobar si el usuario esta logeado.
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        
        $repositorio = $doctrine->getRepository(Incidencia::class);
        $usuario = $this->getUser();
        $misIncidencia = $repositorio->findBy(
           ["usuario" => $usuario],
           ["fechaCreacion" => "DESC"] 
           );
        
        return $this->render('incidencia/misIncidenciasNotificadas.html.twig', [
            'controller_name' => 'IncidenciaController',
            'mis_incidencias' => $misIncidencia,
        ]);
    }
    
    
    
    
}
