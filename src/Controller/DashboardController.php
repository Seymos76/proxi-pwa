<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\BusinessCategory;
use App\Entity\City;
use App\Entity\TimeTable;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Proxi Pwa');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-dashboard'),
            MenuItem::section('Boutique', 'fa fa-home'),
            MenuItem::linkToCrud('Commerce', 'fa fa-building', Business::class),
            MenuItem::linkToCrud('Horaires', 'fa fa-clock', TimeTable::class),
            MenuItem::linkToCrud('Activités', 'fa fa-city', BusinessCategory::class),
            MenuItem::linkToCrud('Communes', 'fa fa-map', City::class),
        ];
    }
}
