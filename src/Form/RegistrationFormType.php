<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input-date',
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('adress', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('postcode', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-input-check',
                ],
            ])

            ->add('plainPassword', RepeatedType::class, [
                'constraints' => [
                    new NotBlank(), 
                    new Regex([
                        'pattern' => ('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{5,}$/'),
                        'message' => 'your password is too weak'
                    ])  
                ], 
                
                'attr' => [
                    'class' => 'form-input-text',
                ],
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password', 'attr' => [
                    'class' => 'form-input-text',
                ],],
                'second_options' => ['label' => 'Confirm Password', 'attr' => [
                    'class' => 'form-input-text',
                ],]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
