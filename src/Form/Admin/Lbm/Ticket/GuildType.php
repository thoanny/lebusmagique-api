<?php

namespace App\Form\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Guild;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uid', TextType::class, [
                'label' => 'UID'
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de la guilde'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('sortOrder', IntegerType::class, [
                'label' => 'Ordre'
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Active',
                'required' => false,
            ])
            ->add('token', TextType::class, [
                'label' => 'Clé API du maître de guilde'
            ])
            ->add('guildUid', TextType::class, [
                'label' => 'Identifiant de la guilde'
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
