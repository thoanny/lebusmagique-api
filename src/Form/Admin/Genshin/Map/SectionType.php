<?php

namespace App\Form\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Map;
use App\Entity\Genshin\Map\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('name', TextType::class, [
                'label' => 'Intitulé',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Ordre',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('map', EntityType::class, [
                'class' => Map::class,
                'choice_label' => 'name',
                'label' => 'Carte',
                'attr' => ['class' => 'select select-bordered'],
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
            'data_class' => Section::class,
        ]);
    }
}
