<?php

namespace App\Form\Admin\Genshin\Map;

use App\Entity\Genshin\Map\Icon;
use App\Entity\Genshin\Map\Marker;
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
use Vich\UploaderBundle\Form\Type\VichImageType;

class MarkerType extends AbstractType
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
                'required' => false,
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
            ->add('video', UrlType::class, [
                'required' => false,
                'label' => 'Vidéo',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('guide', UrlType::class, [
                'required' => false,
                'label' => 'Guide',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('x', IntegerType::class, [
                'label' => 'Position X',
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('y', IntegerType::class, [
                'label' => 'Position Y',
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
            ->add('icon', EntityType::class, [
                'required' => false,
                'class' => Icon::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Icône',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'label' => 'Image',
                'label_attr' => ['class' => 'label-text'],
                'attr' => ['class' => 'file-input file-input-bordered w-full'],
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
            'data_class' => Marker::class,
        ]);
    }
}
