<?php

namespace App\Form\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Time;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uid', TextType::class, [
                'label' => 'UID',
                'row_attr' => [ 'class' => 'form-control' ],
                'attr' => ['class' => 'input input-bordered w-full'],
                'label_attr' => ['class' => 'label label-text'],
            ])
            ->add('name', TextType::class, [
                'label' => 'Intitulé',
                'row_attr' => [ 'class' => 'form-control' ],
                'attr' => ['class' => 'input input-bordered w-full'],
                'label_attr' => ['class' => 'label label-text'],
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
            'data_class' => Time::class,
        ]);
    }
}
