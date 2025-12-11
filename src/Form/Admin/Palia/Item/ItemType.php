<?php

namespace App\Form\Admin\Palia\Item;

use App\Entity\Palia\Item;
use App\Entity\Palia\ItemCategory;
use App\Entity\Palia\Location;
use App\Form\Admin\Palia\ItemBuyType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ItemType extends AbstractType
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
            ->add('rarity', ChoiceType::class, [
                'label' => 'Rareté',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'choices' => [
                    '' => 'default',
                    'Commun' => 'common',
                    'Peu commun' => 'uncommon',
                    'Rare' => 'rare',
                    'Épique' => 'epic',
                    'Légendaire' => 'legendary',
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'textarea textarea-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('focus', IntegerType::class, [
                'label' => 'Focus',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('focusQuality', IntegerType::class, [
                'label' => '⭐Focus',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('priceBase', IntegerType::class, [
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('priceQuality', IntegerType::class, [
                'label' => '⭐Prix',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'input input-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'textarea textarea-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
            ])
            ->add('iconFile', VichImageType::class, [
                'label' => 'Icône',
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
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'label_attr' => [
                    'class' => 'label label-text'
                ],
                'attr' => [
                    'class' => 'select select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'class' => ItemCategory::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC'),
                'choice_label' => 'name',
            ])
            ->add('locations', EntityType::class, [
                'label' => 'Localisations',
                'required' => false,
                'class' => Location::class,
                'query_builder' => fn(EntityRepository $er): QueryBuilder => $er->createQueryBuilder('l')
                    ->orderBy('l.name', 'ASC'),
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
            ->add('purchases', CollectionType::class, [
                'entry_type' => ItemBuyType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Acheter',
                'label_attr' => [
                    'class' => 'text-xl text-secondary font-semibold mt-4 inline-block'
                ],
                'attr' => ['class' => 'grid grid-cols-1 gap-2 mt-4'],
            ])
            ->add('add_purchase', ButtonType::class, [
                'label' => 'Ajouter un moyen d\'acheter',
                'attr' => [
                    'data-collection-holder-id' => 'item_purchases',
                    'class' => 'btn btn-secondary btn-sm mt-4'
                ]
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
            'data_class' => Item::class,
        ]);
    }
}
