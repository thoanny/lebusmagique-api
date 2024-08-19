<?php

namespace App\Form\Admin\Gw2;

use App\Entity\Gw2\Decoration;
use App\Entity\Gw2\DecorationCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class DecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('thumbnailFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'image_uri' => true,
                'label' => 'Image',
                'label_attr' => ['class' => 'label-text'],
                'attr' => ['class' => 'file-input file-input-bordered w-full'],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => ['Hall de guilde' => 'guildhall', 'Pavillon' => 'homestead'],
                'attr' => [
                    'class' => 'select select-bordered w-full'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => DecorationCategory::class,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Decoration::class,
        ]);
    }
}
