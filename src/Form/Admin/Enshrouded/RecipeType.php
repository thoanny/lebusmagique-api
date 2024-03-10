<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\Item;
use App\Entity\Enshrouded\Recipe;
use App\Entity\Enshrouded\RecipeCategory;
use App\Entity\Enshrouded\RecipeSource;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('outputItem', EntityType::class, [
                'label' => 'Objet produit',
                'class' => Item::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('outputQuantity', IntegerType::class, [
                'label' => 'Quantité produite'
            ])
            ->add('outputDuration', IntegerType::class, [
                'label' => 'Durée de production',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => RecipeCategory::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('rc')
                        ->orderBy('rc.root, rc.lft', 'ASC');
                },
            ])
            ->add('requirements', CollectionType::class, [
                'entry_type' => RecipeRequirementType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'label_attr' => [
                    'class' => 'text-xl text-secondary font-semibold mt-4 inline-block'
                ],
                'attr' => ['class' => 'grid grid-cols-4 gap-4 mt-4'],
            ])
            ->add('add_requirement', ButtonType::class, [
                'label' => 'Ajouter un prérequis',
                'attr' => [
                    'data-collection-holder-id' => 'recipe_requirements',
                    'class' => 'btn btn-secondary btn-sm mt-4'
                ]
            ])
            ->add('ingredients', CollectionType::class, [
                'entry_type' => RecipeIngredientType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'label_attr' => [
                    'class' => 'text-xl text-secondary font-semibold mt-4 inline-block'
                ],
                'attr' => ['class' => 'grid grid-cols-4 gap-4 mt-4'],
            ])
            ->add('add_ingredient', ButtonType::class, [
                'label' => 'Ajouter un ingrédient',
                'attr' => [
                    'data-collection-holder-id' => 'recipe_ingredients',
                    'class' => 'btn btn-secondary btn-sm mt-4'
                ]
            ])
            ->add('source', EntityType::class, [
                'label' => 'Origine du produit',
                'class' => RecipeSource::class,
                'required' => false,
                'help' => 'Laisser vide si : fabrication manuelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
            'xyz' => []
        ]);
    }
}
