<?php

namespace App\Form\Admin\Gw2;

use App\Entity\Gw2\Expansion;
use App\Entity\Gw2Api\WizardVaultObjective;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WizardVaultObjectiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('uid', IntegerType::class, [
//                'label' => 'UID',
//                'label_attr' => [
//                    'class' => 'label label-text'
//                ],
//                'attr' => [
//                    'class' => 'input input-bordered'
//                ],
//                'row_attr' => [
//                    'class' => 'form-control'
//                ]
//            ])
            ->add('title', TextType::class, [
                'label' => 'Intitulé',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('period', ChoiceType::class, [
                'label' => 'Périodicité',
                'choices' => [
                    'Quotidien' => 'daily',
                    'Hebdomadaire' => 'weekly',
                    'Special' => 'special'
                ],
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Mode de jeu',
                'choices' => [
                    'JcE' => 'pve',
                    'JcJ' => 'pvp',
                    'McM' => 'wvw'
                ],
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('tip', TextareaType::class, [
                'label' => 'Conseil',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'textarea textarea-bordered',
                    'rows' => 5
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('astralAcclaim', IntegerType::class, [
                'label' => 'Acclamations astrales',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Actif',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ],
                'required' => false,
            ])
            ->add('expansion', EntityType::class, [
                'label' => 'Extensions',
                'class' => Expansion::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'inline-checkboxes'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
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
            'data_class' => WizardVaultObjective::class,
        ]);
    }
}
