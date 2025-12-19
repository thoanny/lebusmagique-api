<?php

namespace App\Controller\Admin\Lbm\Ticket;

use App\Entity\Lbm\Ticket\Guild;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/lbm/tickets/guilds', name: 'lbm_ticket_guild')]
class GuildCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Guild::class;
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
            TextField::new('name')->setLabel('Nom de la guilde'),
            SlugField::new('uid')->setTargetFieldName('name'),
            TextEditorField::new('description')->hideOnIndex(),
            IntegerField::new('sortOrder')->setLabel('Ordre'),
            BooleanField::new('active'),
            TextField::new('token')
                ->hideOnIndex()
                ->setLabel('Clé API du maître de guilde')
            ,
            TextField::new('guildUid')
                ->hideOnIndex()
                ->setLabel('Identifiant de la guilde')
            ,
        ];
    }

}
