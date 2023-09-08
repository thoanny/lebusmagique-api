<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\Character;
use App\Entity\Palia\CharacterGroup;
use App\Entity\Palia\Location;
use App\Entity\Palia\Skill;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control col-span-3'
                ]
            ])
            ->add('romance', CheckboxType::class, [
                'label' => 'Romance',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ],
                'required' => false,
            ])
            ->add('shepp', CheckboxType::class, [
                'label' => 'Shepp',
                'label_attr' => [
                    'class' => 'label-text'
                ],
                'attr' => [
                    'class' => 'toggle toggle-primary'
                ],
                'required' => false,
            ])
            ->add('avatarFile', VichImageType::class, [
                'label' => 'Avatar',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'file-input file-input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'download_uri' => false,
            ])
            ->add('illustrationFile', VichImageType::class, [
                'label' => 'Illustration',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'file-input file-input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'download_uri' => false,
                'imagine_pattern' => 'palia_character_illustration'
            ])
            ->add('locations', EntityType::class, [
                'label' => 'Localisations',
                'required' => false,
                'class' => Location::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.name', 'ASC');
                },
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
            ->add('characterGroup', EntityType::class, [
                'label' => 'Groupe',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'class' => CharacterGroup::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('skill', EntityType::class, [
                'label' => 'Compétence',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'class' => Skill::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('wishes', CollectionType::class, [
                'entry_type' => CharacterWishType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Objets souhaités (hebdomadaires)',
                'label_attr' => [
                    'class' => 'text-xl text-secondary font-semibold mt-4 inline-block'
                ],
                'attr' => ['class' => 'grid grid-cols-4 gap-4 mt-4'],
            ])
            ->add('add_wish', ButtonType::class, [
                'label' => 'Ajouter un souhait',
                'attr' => [
                    'data-collection-holder-id' => 'character_wishes',
                    'data-collection-limit' => 4,
                    'class' => 'btn btn-secondary btn-sm mt-4'
                ]
            ])
            // TODO
//            ->add('add_gift', ButtonType::class, [
//                'label' => 'Ajouter un cadeau',
//                'attr' => [
//                    'data-collection-holder-id' => 'character_gifts',
//                    'class' => 'btn btn-secondary btn-sm mt-2'
//                ]
//            ])
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
            'data_class' => Character::class,
        ]);
    }
}
