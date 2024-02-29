<?php

namespace App\Form\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Achievement;
use App\Entity\Gw2\Fish\Bait;
use App\Entity\Gw2\Fish\Fish;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('power', TextType::class, [
                'required' => false,
                'label' => 'Puissance de pêche',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered w-full'
                ]
            ])
            ->add('specialization', ChoiceType::class, [
                'required' => false,
                'label' => 'Spécialisation',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered',
                ],
                'choices' => [
                    'Justicier' => 'vindicator',
                    'Méchamancien' => 'mechanist',
                    'Augure' => 'harbinger',
                    'Spectre' => 'specter',
                    'Subjugueur' => 'willbender',
                    'Jurelame' => 'bladesworn',
                    'Indomptable' => 'untamed',
                    'Virtuose' => 'virtuoso',
                    'Catalyseur' => 'catalyst',
                ]
            ])
            ->add('strangeDiet', CheckboxType::class, [
                'required' => false,
                'label' => 'Succès : Un régime particulier',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
            ])
            ->add('baitAny', CheckboxType::class, [
                'required' => false,
                'label' => 'Appât quelconque',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
            ])
            ->add('bait', EntityType::class, [
                'class' => Bait::class,
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'Appât',
                'required' => false
            ])
            ->add('achievement', EntityType::class, [
                'class' => Achievement::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'Succès de pêche',
                'required' => false
            ])
            ->add('fishHoles', CollectionType::class, [
                'entry_type' => FishHoleType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Coins de pêche',
                'label_attr' => [
                    'class' => 'text-xl text-secondary font-semibold mt-4 inline-block'
                ],
                'attr' => ['class' => 'grid grid-cols-1 gap-2 mt-4'],
            ])
            ->add('add_hole', ButtonType::class, [
                'label' => 'Ajouter un coin de pêche',
                'attr' => [
                    'data-collection-holder-id' => 'item_fish_fishHoles',
                    'class' => 'btn btn-secondary btn-sm mt-4'
                ]
            ])
            ->add('fishTimes', CollectionType::class, [
                'entry_type' => FishTimeType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Horaires',
                'label_attr' => [
                    'class' => 'text-xl text-secondary font-semibold mt-4 inline-block'
                ],
                'attr' => ['class' => 'grid grid-cols-1 gap-2 mt-4'],
            ])
            ->add('add_time', ButtonType::class, [
                'label' => 'Ajouter un horaire',
                'attr' => [
                    'data-collection-holder-id' => 'item_fish_fishTimes',
                    'class' => 'btn btn-secondary btn-sm mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fish::class,
        ]);
    }
}
