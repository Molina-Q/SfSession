<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Programme;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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

                    // return $er->createQueryBuilder('m')
                    //     ->leftJoin('m.programmes', 'p')
                    //     // ->where($this->expr()->notIn('p.modules', $excludedModule));
                    //     // ->where('p.Session = :session_id')
                    //     ->where(':session_id NOT IN (p.Session)')
                    //     // ->andWhere('m.id NOT IN (p.Module)')
                    //     ->setParameter('session_id', $this->session_id);
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
