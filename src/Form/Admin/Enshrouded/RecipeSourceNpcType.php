<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\Npc;
use App\Entity\Enshrouded\RecipeSource;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeSourceNpcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('npc', EntityType::class, [
                'label' => 'Personnage',
                'class' => Npc::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('n')
                    ->orderBy('n.name', 'ASC'),
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeSource::class,
        ]);
    }
}
