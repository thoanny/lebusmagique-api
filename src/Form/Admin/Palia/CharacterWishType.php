<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\CharacterWish;
use App\Entity\Palia\Item;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterWishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => ['class' => 'hidden'],
            ])
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
