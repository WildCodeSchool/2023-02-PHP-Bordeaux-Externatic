<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Contract;
use App\Entity\Job;
use App\Entity\Joboffer;
use App\Entity\Resume;
use App\Entity\Salary;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator

            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Utilisateurs');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Créer utilisateur', 'fas fa-plus-circle', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir utilisateurs', 'fas fa-eye', User::class),
        ]);

        yield MenuItem::section('Catégories');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Créer catégorie', 'fas fa-plus-circle', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir catégories', 'fas fa-eye', Category::class),
        ]);

        yield MenuItem::section('Entreprises');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Créer entreprise', 'fas fa-plus-circle', Company::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir entreprise', 'fas fa-eye', Company::class),
        ]);

        yield MenuItem::section('Contrats');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Créer contrat', 'fas fa-plus-circle', Contract::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir contrats', 'fas fa-eye', Contract::class),
        ]);

        yield MenuItem::section('Emplois');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Créer emploi', 'fas fa-plus-circle', Job::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir emplois', 'fas fa-eye', Job::class),
        ]);

        yield MenuItem::section('Offres d\'emploi');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud(
                'Créer offre d\'emploi',
                'fas fa-plus-circle',
                Joboffer::class
            )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir offre d\'emploi', 'fas fa-eye', Joboffer::class),
        ]);

        yield MenuItem::section('CV');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Voir CV', 'fas fa-eye', Resume::class),
        ]);

        yield MenuItem::section('Salaires');

        yield MenuItem::subMenu('Actions', 'fas fa-bar')->setSubItems([
            MenuItem::linkToCrud('Créer salaire', 'fas fa-plus-circle', Salary::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir salaires', 'fas fa-eye', Salary::class),
        ]);
    }
}
