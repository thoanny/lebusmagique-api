<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ]
            ])
            ->add('iconFile', VichImageType::class, [
                'label' => 'Icône',
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'file-input file-input-bordered'
                ],
                'required' => false,
                'download_uri' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
