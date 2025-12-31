<?php

namespace App\Controller\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Blacklist;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/lbm/tickets/blacklist', name: 'lbm_ticket_blacklist')]
class BlacklistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blacklist::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('accountName')
                ->setLabel('Nom de compte')
            ,
            TextareaField::new('reason')
                ->hideOnIndex()
                ->setLabel('Raison')
            ,
            TextareaField::new('comment')
                ->hideOnIndex()
                ->setLabel('Commentaire (privé)')
            ,
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->setLabel('Créé le')
            ,
            AssociationField::new('user')
                ->hideOnForm()
                ->setLabel('Créé par')
            ,
        ];
    }

    public function createEntity(string $entityFqcn): Blacklist
    {
        $blacklist = new Blacklist();
        $blacklist->setCreatedAt(new \DateTimeImmutable());
        $blacklist->setUser($this->getUser());

        return $blacklist;
    }

}
