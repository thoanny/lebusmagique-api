<?php

namespace App\Form\Admin\Palia;

use App\Entity\Palia\Currency;
use App\Entity\Palia\ItemBuy;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemBuyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('source', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Boutique' => [
                        'Family Farm' => 'family_farm',
                        'General Store' => 'general_store',
                        'Furniture Store' => 'furniture_store',
                        'City Hall' => 'city_hall',
                        'Tavern' => 'tavern',
                    ],
                    'Personnage' => [
                        'Auni' => 'auni',
                        'Badruu' => 'badruu',
                        'Einar' => 'einar',
                        'Hassian' => 'hassian',
                        'Hodari' => 'hodari',
                        'Reth' => 'reth',
                        'Tish' => 'tish',
                    ]
                ],
                'attr' => [
                    'class' => 'select select-sm select-bordered'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('quantity', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input input-sm input-bordered',
                    'placeholder' => 'Quantité'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('price', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input input-sm input-bordered',
                    'placeholder' => 'Prix'
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('currency', EntityType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'select select-sm select-bordered',
                ],
                'row_attr' => [
                    'class' => 'form-control'
                ],
                'class' => Currency::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
            ->add('remove_item', ButtonType::class, [
                'label' => 'Supprimer cette source',
                'attr' => [
                    'class' => 'btn btn-outline btn-block btn-sm remove-item'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemBuy::class,
        ]);
    }
}
