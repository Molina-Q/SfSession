<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UpdateModuleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'label',
                'attr' => [
                    'class' => 'form-input-select',
                ]
            ])
            ->add('label', TextType::class, [
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
