<?php

namespace App\Form\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Guild;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('token', TextType::class, [
                'label' => 'Clé API GW2 du GM',
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
            ->add('guildUid', TextType::class, [
                'label' => 'Identifiant de la guilde',
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
            ->add('name', TextType::class, [
                'label' => 'Nom de la guilde',
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
            ->add('uid', TextType::class, [
                'label' => 'UID',
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
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'textarea textarea-bordered'
                ]
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Ordre d\'affichage',
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
            ->add('active', CheckboxType::class, [
                'label' => 'Active',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ],
                'row_attr' => [
                    'class' => 'mt-2'
                ],
                'required' => false,
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
            'data_class' => Guild::class,
        ]);
    }
}
