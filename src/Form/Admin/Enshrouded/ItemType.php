<?php

namespace App\Form\Admin\Enshrouded;

use App\Entity\Enshrouded\Item;
use App\Entity\Enshrouded\ItemCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                'label' => 'Nom de l\'objet'
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => ItemCategory::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('level', IntegerType::class, [
                'label' => 'Niveau',
                'required' => false
            ])
            ->add('quality', ChoiceType::class, [
                'label' => 'Qualité',
                'choices' => [
                    'Commun' => 'common',
                    'Peu commun' => 'uncommon',
                    'Rare' => 'rare',
                    'Épique' => 'epic',
                    'Légendaire' => 'legendary',
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
            ])
            ->add('equippable', ChoiceType::class, [
                'label' => 'Équipable/Utilisation directe',
                'choices' => [
                    'Équipable' => 'equippable',
                    'Équipable (à distance)' => 'ranger',
                    'Utilisation directe' => 'direct_use',
                ],
                'required' => false
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
            'data_class' => Item::class,
        ]);
    }
}
