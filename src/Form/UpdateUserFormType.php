<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UpdateUserFormType extends AbstractType
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
        ->add('address', TextType::class, [
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
