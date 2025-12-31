<?php

namespace App\Controller\Admin\Lbm\Event;

use App\Entity\Lbm\Event\Role;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/lbm/events/roles', name: 'lbm_event_role')]
class RoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['username' => 'ASC'])
            ->setPaginatorPageSize(999)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username', 'Nom de compte GW2'),
            ChoiceField::new('role', 'Rôle')
                ->setChoices([
                    'Organisateur' => 'ORGA',
                    'Lead ext.' => 'EXT',
                    'Streamer' => 'STREAM',
                ]),
        ];
    }
}
