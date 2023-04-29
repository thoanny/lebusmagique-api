<?php

namespace App\Form\Admin\Gw2;

use App\Entity\Gw2Api\Item;
use App\Entity\Gw2Api\ItemTag;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('tag', EntityType::class, [
                'class' => ItemTag::class,
                'label' => 'Mots-clés',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
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
            'data_class' => Item::class,
        ]);
    }
}
