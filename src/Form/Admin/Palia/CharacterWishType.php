<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\CharacterWish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterWishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('item', ItemAutocompleteField::class)
            ->add('remove_item', ButtonType::class, [
                'label' => 'Supprimer cet objet',
                'attr' => [
                    'class' => 'btn btn-outline btn-block btn-sm mt-2 remove-item'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CharacterWish::class,
        ]);
    }
}
