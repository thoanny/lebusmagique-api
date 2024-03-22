<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\RecipeRequirement;
use App\Entity\Enshrouded\RecipeSource;
use App\Repository\Enshrouded\RecipeSourceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeRequirementType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('source', EntityType::class, [
                'label' => false,
                'class' => RecipeSource::class,
            ])
            ->add('remove_item', ButtonType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'btn btn-outline btn-block btn-sm mt-2 remove-item'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeRequirement::class,
            'choices' => null
        ]);
    }
}
