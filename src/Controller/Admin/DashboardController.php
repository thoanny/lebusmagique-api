<?php

namespace App\Controller\Admin;

use App\Entity\Lbm\Ticket\Blacklist;
use App\Entity\Lbm\Ticket\Guild;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::section('Guild Wars 2');
        yield MenuItem::section('Le Bus Magique');
        yield MenuItem::subMenu('Tickets')
            ->setSubItems([
                MenuItem::linkToCrud('Liste noire', 'fa fa-user-lock', Blacklist::class),
                MenuItem::linkToCrud('Guildes', 'fa fa-users', Guild::class),
                MenuItem::linkToCrud('Validations', 'fa fa-user-check', Blacklist::class),
                MenuItem::linkToCrud('Tickets', 'fa fa-ticket', Blacklist::class),
            ]);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class)
            ->setPermission('ROLE_ADMIN')
        ;
    }
}
