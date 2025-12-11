<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\RecipeCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la catégorie'
            ])
            ->add('parent', EntityType::class, [
                'class' => RecipeCategory::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('rc')
                    ->orderBy('rc.root, rc.lft', 'ASC'),
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeCategory::class,
        ]);
    }
}
