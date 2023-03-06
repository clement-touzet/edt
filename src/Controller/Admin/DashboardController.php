<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\Cours;
use App\Entity\Matiere;
use App\Entity\Salle;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProfesseurCrudController::class)->generateUrl());
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userMenu = parent::configureUserMenu($user);
        $userMenu->setMenuItems([]);

        return $userMenu;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Emploi du temps');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Professeur', 'fa fa-chalkboard-user');
        yield MenuItem::linkToCrud('Matiere', 'fas fa-list', Matiere::class);
        yield MenuItem::linkToCrud('Avis', 'fas fa-star', Avis::class);
        yield MenuItem::section('Gestion des cours');
        yield MenuItem::linkToCrud('Cours', 'fas fa-book-open', Cours::class);
        yield MenuItem::linkToCrud('Salle', 'fas fa-building', Salle::class);
    }
}
?>