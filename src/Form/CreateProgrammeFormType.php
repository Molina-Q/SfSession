<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CreateProgrammeFormType extends AbstractType
{
    private $session_id;
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->session_id = $options['session_id'];

        $builder
            ->add('duration', NumberType::class, [
                'label' => 'Duration (in days)',
                'attr' => [
                    'class' => 'form-input-text',
                ]
            ])

            ->add('Module', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'label',
                
                'attr' => [
                    'class' => 'form-input-text',
                ],
                
                'query_builder' => function (EntityRepository $er): QueryBuilder {

                    $sub = $er->createQueryBuilder('m');

                    $qb = $sub;

                    $qb->leftJoin('m.programmes', 'p')
                        ->where('p.Session = :id');
                
                    $sub = $er->createQueryBuilder('mo');

                    return $sub->where($sub->expr()->notIn('mo.id', $qb->getDQL()))
                        ->setParameter('id', $this->session_id)
                        ->orderBy('mo.label');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
            'session_id' => null,
        ]);
    }
}
