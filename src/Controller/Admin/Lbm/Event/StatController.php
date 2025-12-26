<?php

namespace App\Controller\Admin\Lbm\Event;

use App\Repository\Lbm\Event\EventRepository;
use App\Repository\Lbm\Event\RoleRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[AdminRoute('lbm/events/stats', name: 'lbm_event_stat')]
final class StatController extends AbstractController
{
    #[AdminRoute("/", name: "index")]
    public function index(EventRepository $eventRepository, RoleRepository $roleRepository): Response
    {

        $start = date('Y-m-01 00:00:00', strtotime("- 5 months"));
        $end = date('Y-m-t 23:59:59');

        $months = [];
        for($i=5; $i>=0; $i--) {
            $key = date('Y-m', strtotime("- $i months"));
            $months[$key] = 0;
        }
        $months['TOTAL'] = 0;

        $users = [];
        $total = $months;

        $eventsRoles = $roleRepository->findAll();
        $events = $eventRepository->findForStatistics($start, $end);

        foreach($events as $event) {
            $k = ($event->getStartAt())->format("Y-m");
            if(!isset($users[$event->getLeaderGw2()])) {
                $users[$event->getLeaderGw2()] = $months;
            }

            $users[$event->getLeaderGw2()][$k] += 1;
            $users[$event->getLeaderGw2()]['TOTAL'] += 1;

            $total[$k] += 1;
            $total['TOTAL'] += 1;
        }

        ksort($users);

        $roles = [];
        foreach($eventsRoles as $role) {
            $roles[$role->getUsername()] = $role->getRole();
        }

        return $this->render('admin/lbm/event/stat.html.twig', [
            'users' => $users,
            'roles' => $roles,
            'total' => $total,
        ]);
    }
}
