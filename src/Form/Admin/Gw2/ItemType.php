<?php

namespace App\Form\Admin\Gw2;

use App\Entity\Gw2\Fish\Achievement;
use App\Entity\Gw2\Fish\Hole;
use App\Entity\Gw2Api\Item;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('blackmarket', CheckboxType::class, [
                'required' => false,
                'label' => 'Black Market',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
            ])
            ->add('inventoryManagerTip', TextareaType::class, [
                'required' => false,
                'label' => 'Conseil pour la gestion d\'inventaire',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'rows' => 4
                ],
                'help' => 'Tu peux utiliser Markdown pour formater le texte.',
            ])
            ->add('obteningTip', TextareaType::class, [
                'required' => false,
                'label' => 'Comment l\'obtenir ?',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'rows' => 4
                ],
                'help' => 'Tu peux utiliser Markdown pour formater le texte.',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->add('isFish', CheckboxType::class, [
                'required' => false,
                'label' => 'Poisson',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
            ])
            ->add('fishPower', TextType::class, [
                'required' => false,
                'label' => 'Puissance de pêche',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered w-full'
                ]
            ])
            ->add('fishTime', ChoiceType::class, [
                'required' => false,
                'label' => 'Horaire',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered w-full'
                ],
                'choices' => [
                    'Jour' => 'd',
                    'Nuit' => 'n',
                    'Aube/Crépuscule' => 'dd',
                ]
            ])
            ->add('fishSpecialization', ChoiceType::class, [
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
            ->add('isFishStrangeDietAchievement', CheckboxType::class, [
                'required' => false,
                'label' => 'Succès : Un régime particulier',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ]
            ])
            ->add('fishHole', EntityType::class, [
                'class' => Hole::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('h')
                        ->orderBy('h.name', 'ASC');
                },
                'choice_label' => 'name',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'Zone de pêche',
                'required' => false
            ])
            ->add('fishBaitItem', EntityType::class, [
                'class' => Item::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('i')
                        ->where('i.isFishBait = :true')
                        ->setParameter('true', true)
                        ->orderBy('i.name', 'ASC');
                },
                'choice_value' => 'id',
                'choice_label' => 'name',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'Appât',
                'required' => false
            ])
            ->add('fishAchievement', EntityType::class, [
                'class' => Achievement::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'attr' => ['class' => 'select select-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'Succès de pêche',
                'required' => false
            ])
            ->add('isFishBait', CheckboxType::class, [
                'required' => false,
                'label' => 'Appât',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ],
            ])
            ->add('fishBaitPower', TextType::class, [
                'required' => false,
                'label' => 'Puissance de pêche',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered w-full'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
