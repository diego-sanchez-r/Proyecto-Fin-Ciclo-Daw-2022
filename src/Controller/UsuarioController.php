<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'app_usuario')]
    public function index(Request $request, ManagerRegistry $doctrine,SluggerInterface $slugger): Response
    {
        //Comprobar si el usuario esta logeado.
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        
        $usuario = new Usuario();
        $form = $this->createFormBuilder($usuario)
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
                    'id'=> 'input_foto'
                )
                
            ])
                ->getForm();
                ;
                $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $usuario = $this->getUser();
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
                        $this->getParameter('imagenes_ruta_usuarios'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('aviso','Ha ocurrido un problema al subir la imagen');
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $usuario->setImagen($newFilename);
            }
            
            $usuario = $this->getUser();
            $em = $doctrine->getManager();
            $em->persist($usuario);
            $em->flush();
            
            $this->addFlash("aviso", "Foto Cambiada");
            return $this->redirectToRoute("app_usuario");
        }
        
        return $this->renderForm('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
            'usuarioConectado' => $usuario,
            'form_foto'=>$form
        ]);
    }
    
    /**
     * @Route("/usuario/cambiar/foto", name="edit_foto")
    */
    public function cambiarFotoPerfil(Request $request, ManagerRegistry $doctrine): Response {
        if($this->getUser() === null){
            return $this->redirectToRoute("login");
        }
        
        
        
    }
}
