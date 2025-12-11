<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\MapCategory;
use App\Entity\Enshrouded\MapIcon;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MapCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Intitulé'
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Affiché par défaut',
                'required' => false,
            ])
            ->add('checked', CheckboxType::class, [
                'label' => 'Suivi de progression',
                'required' => false
            ])
            ->add('icon', EntityType::class, [
                'label' => 'Icône',
                'class' => MapIcon::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name'
            ])
            ->add('iconChecked', EntityType::class, [
                'label' => 'Icône (terminé)',
                'class' => MapIcon::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('iconMenuFile', VichImageType::class, [
                'label' => 'Icone du menu',
                'label_attr' => [
                    'class' => 'label'
                ],
                'required' => false,
                'download_uri' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MapCategory::class,
        ]);
    }
}
