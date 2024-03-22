<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\Npc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NpcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du personnage',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('iconFile', VichImageType::class, [
                'label' => 'Icône',
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
            'data_class' => Npc::class,
        ]);
    }
}
