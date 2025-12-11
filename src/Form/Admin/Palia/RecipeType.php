<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\Item;
use App\Entity\Palia\Recipe;
use App\Entity\Palia\Skill;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('craftTime', IntegerType::class, [
                'label' => 'Durée de fabrication',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('item', EntityType::class, [
                'label' => 'Objet produit',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control col-span-3'
                ],
                'class' => Item::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
            ])
            ->add('workshop', EntityType::class, [
                'label' => 'Atelier',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control col-span-3'
                ],
                'class' => Item::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
            ])
            ->add('skill', EntityType::class, [
                'label' => 'Compétence',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'class' => Skill::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC'),
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('ingredients', CollectionType::class, [
                'entry_type' => RecipeIngredientType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Ingrédients',
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
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
