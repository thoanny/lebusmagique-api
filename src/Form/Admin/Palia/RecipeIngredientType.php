<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\RecipeIngredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label_attr' => [
                    'class' => 'hidden'
                ],
                'attr' => [
                    'class' => 'input input-bordered',
                    'placeholder' => 'Quantité'
                ],
                'row_attr' => [
                    'class' => 'form-control mb-2'
                ],
            ])
            ->add('item', ItemAutocompleteField::class)
            ->add('remove_item', ButtonType::class, [
                'label' => 'Supprimer cet ingrédient',
                'attr' => [
                    'class' => 'btn btn-outline btn-block btn-sm mt-2 remove-item'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}
