<?php

namespace App\Form\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Icon;
use App\Entity\Genshin\Map\Map;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Intitulé',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('active', CheckboxType::class, [
                'required' => false,
                'label' => 'Active',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
            ])
            ->add('bounds', TextType::class, [
                'label' => 'Limites de la carte',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('center', TextType::class, [
                'label' => 'Centre de la carte',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('zoom', IntegerType::class, [
                'label' => 'Zoom par défaut',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('tiles', TextType::class, [
                'label' => 'URL des tuiles',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('minZoom', IntegerType::class, [
                'label' => 'Zoom minimum',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('maxZoom', IntegerType::class, [
                'label' => 'Zoom maximum',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('icon', EntityType::class, [
                'class' => Icon::class,
                'choice_label' => 'name',
                'label' => 'Icône',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Ordre',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Map::class,
        ]);
    }
}
