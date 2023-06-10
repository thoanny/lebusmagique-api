<?php

namespace App\Form\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Group;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('group', EntityType::class, [
                'label' => 'Groupe',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'class' => Group::class,
                'choice_label' => function ($group) {
                    return $group->getTitle() . ' - ' . $group->getSection()->getMap()->getName();
                }
            ])
            ->add('title', TextType::class, [
                'label' => 'Intitulé des marqueurs',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('map', ChoiceType::class, [
                'label' => 'Carte originale',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'choices' => [
                    'Mines du Gouffre' => 'chasm',
                    'Enkanomiya' => 'enkanomiya',
                    'Teyvat' => '',
                    'Trois royaumes' => 'troisroyaumes'
                ]
            ])
            ->add('data', TextareaType::class, [
                'label' => 'Données à importer',
                'attr' => ['class' => 'textarea textarea-bordered', 'rows' => 6],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Importer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
