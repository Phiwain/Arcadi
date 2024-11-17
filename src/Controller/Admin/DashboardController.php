<?php

namespace App\Controller\Admin;

use App\Entity\Amnial;
use App\Entity\AnimalRace;
use App\Entity\Avis;
use App\Entity\Habitats;
use App\Entity\Ouvertures;
use App\Entity\Rapports;
use App\Entity\Service;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
      return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace Professionnel - Administrateur');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Ouverture', 'fas fa-clock', Ouvertures::class);
        yield MenuItem::linkToCrud('Service', 'fas fa-concierge-bell', Service::class);
        yield MenuItem::linkToCrud('Habitats', 'fas fa-concierge-bell', Habitats::class);
        yield MenuItem::linkToCrud('Race des Animaux', 'fas fa-concierge-bell', AnimalRace::class);
        yield MenuItem::linkToCrud('Animaux', 'fas fa-concierge-bell', Amnial::class);

        yield MenuItem::linkToRoute('Compte rendus vétérinaires', 'fas fa-paw', 'app_all_rapports');
    }
}
