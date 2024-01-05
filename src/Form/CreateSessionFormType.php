<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CreateSessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input-date',
                ]
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-input-date',
                ]
            ])
            ->add('nb_slot', NumberType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
            ->add('Formation', EntityType::class, [
                'attr' => [
                    'class' => 'form-input-select',
                ],
                'class' => Formation::class,
                'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
