<?php

namespace App\Form\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Group;
use App\Entity\Genshin\Map\Icon;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Intitulé',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('text', TextareaType::class, [
                'required' => false,
                'label' => 'Texte',
                'attr' => ['class' => 'textarea textarea-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('format', ChoiceType::class, [
                'label' => 'Format',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'choices' => [
                    'Todo' => 'todo',
                    'Image' => 'image',
                    'Vidéo' => 'video',
                    'Pop-Up' => 'popup',
                    'Bannière' => 'banner',
                    'Région' => 'region',
                    'Simple' => 'simple'
                ]
            ])
            ->add('guide', UrlType::class, [
                'required' => false,
                'label' => 'Guide',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('checkbox', CheckboxType::class, [
                'required' => false,
                'label' => 'Suivi de progression',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
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
            ->add('position', IntegerType::class, [
                'label' => 'Ordre',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('x', IntegerType::class, [
                'label' => 'Position X par défaut',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('y', IntegerType::class, [
                'label' => 'Position Y par défaut',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('z', IntegerType::class, [
                'label' => 'Zoom par défaut',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('icon', EntityType::class, [
                'class' => Icon::class,
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
                'label' => 'Icône',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary btn-block mt-1'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
