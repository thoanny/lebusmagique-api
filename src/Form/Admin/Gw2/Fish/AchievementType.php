<?php

namespace App\Form\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Achievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AchievementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'Nom du succès'
            ])
            ->add('achievementId', IntegerType::class, [
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'ID du succès'
            ])
            ->add('achievementRepeatId', IntegerType::class, [
                'attr' => ['class' => 'input input-bordered'],
                'label_attr' => ['class' => 'label-text'],
                'label' => 'ID du succès répétable'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary mt-4']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achievement::class,
        ]);
    }
}
