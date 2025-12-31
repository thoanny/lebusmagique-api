<?php

namespace App\Controller\Admin\Lbm\Event;

use App\Entity\Lbm\Event\Event;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/lbm/events/events', name: 'lbm_event')]
class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $imgPath = $this->getParameter('lbm.event.image');
        return [
            IdField::new('id'),
            TextField::new('title', 'Titre'),
            DateTimeField::new('startAt', 'Début'),
            DateTimeField::new('endAt', 'Fin'),
            TextareaField::new('description')->onlyOnDetail(),
            TextField::new('type'),
            TextField::new('leaderGw2'),
            ImageField::new('image')->setBasePath($imgPath),
        ];
    }
}
