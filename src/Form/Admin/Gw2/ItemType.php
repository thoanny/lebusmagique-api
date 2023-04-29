<?php

namespace App\Form\Admin\Gw2;

use App\Entity\Gw2Api\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uid')
            ->add('name')
            ->add('type')
            ->add('subtype')
            ->add('rarity')
            ->add('blackmarket')
            ->add('inventoryManagerTip')
            ->add('obteningTip')
            ->add('tag')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
