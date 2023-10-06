<?php

namespace App\Form\Admin\Gw2\Fish;

use App\Entity\Gw2\Fish\Daily;
use App\Entity\Gw2Api\Item;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DailyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'row_attr' => [ 'class' => 'form-control' ],
                'attr' => ['class' => 'input input-bordered w-full'],
                'label_attr' => ['class' => 'label label-text'],
            ])
            ->add('fish', EntityType::class, [
                'class' => Item::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC')
                        ->where('i.isFish = :true')
                        ->setParameter('true', true);
                },
                'choice_label' => 'name',
                'label' => 'Poisson',
                'row_attr' => [ 'class' => 'form-control' ],
                'attr' => ['class' => 'select select-bordered w-full'],
                'label_attr' => ['class' => 'label label-text'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Daily::class,
        ]);
    }
}
