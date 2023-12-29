<?php

namespace App\Form\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\FishHole;
use App\Entity\Gw2\Fish\Hole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FishHoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hole', EntityType::class, [
                'label' => false,
                'class' => Hole::class,
                'choice_label' => 'name',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'select select-sm w-full select-bordered',
                ],
            ])
            ->add('frequency', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Faible chance' => 'low',
                    'Meilleure chance' => 'best',
                    'Fréquemment repéré' => 'high'
                ],
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'select select-sm w-full select-bordered',
                ],
                'required' => false
            ])
            ->add('remove_item', ButtonType::class, [
                'label' => 'Supprimer',
                'attr' => [
                    'class' => 'btn btn-outline btn-block btn-sm remove-item'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FishHole::class,
        ]);
    }
}
