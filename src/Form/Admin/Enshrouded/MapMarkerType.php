<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\MapCategory;
use App\Entity\Enshrouded\MapIcon;
use App\Entity\Enshrouded\MapMarker;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MapMarkerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => MapCategory::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC'),
                'choice_label' => 'name',
            ])
            ->add('name', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('posX', NumberType::class, [
                'label' => 'Position X'
            ])
            ->add('posY', NumberType::class, [
                'label' => 'Position Y'
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'label_attr' => [
                    'class' => 'label'
                ],
                'required' => false,
                'download_uri' => false,
            ])
            ->add('video', TextType::class, [
                'label' => 'ID YouTube',
                'required' => false
            ])
            ->add('icon', EntityType::class, [
                'label' => 'Icône',
                'class' => MapIcon::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('iconChecked', EntityType::class, [
                'label' => 'Icône (terminé)',
                'class' => MapIcon::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MapMarker::class,
        ]);
    }
}
