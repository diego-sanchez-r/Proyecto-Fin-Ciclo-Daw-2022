<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;



class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indique su dirección de correo electrónico.',
                    ]),
                ],
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Ingrese Correo Electronico ',
                    'class' => 'form-control'
                )
            ])
            ->add('Password', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indique una contraseña.',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'La contraseña debe tener un mínimo de {{ limit }} carácteres.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Ingrese la Password ',
                    'class' => 'form-control'
                )
            ])
            ->add("nombre", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indique su nombre.',
                    ]),
                ],
                'label' => false,
               'attr' => array(
                    'placeholder' => 'Ingrese Nombre ',
                    'class' => 'form-control'
                )
            ])
            ->add("apellidos", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indique sus apellidos.',
                    ]),
                ],
               'label' => false,
               'attr' => array(
                    'placeholder' => 'Ingrese Apellidos ',
                    'class' => 'form-control'
                )
            ])
            ->add("telefono", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indique su número de teléfono.',
                    ]),
                ],
               'label' => false,
               'attr' => array(
                    'placeholder' => 'Ingrese Teléfono ',
                    'class' => 'form-control'
                )
               ])
               ->add("codigo", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, indique su código postal.',
                    ]),
                ],
               'label' => false,
               'attr' => array(
                    'placeholder' => 'Ingrese Código Postal ',
                    'class' => 'form-control'
                )
               ])
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
                    'class' => 'form-control'
                ),
                'label' => false,
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debe aceptar los términos y condiciones.',
                    ]),
                ],
                'attr' => array(
                    'class' => 'form-check-input'
                ),
                'label' => " Aceptar Términos y Condiciones -",
            ])
               ->add('Registrar', SubmitType::class, [
                'attr' => array(
                    'class' => 'btn btn-primary w-100',
                )
               ])
               ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
