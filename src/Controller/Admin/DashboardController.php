<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Document;
use App\Entity\DocumentCategorie;
use App\Entity\Evenement;
use App\Entity\Sport;
use App\Entity\Type;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        if($this->getUser()->getRoles() === 'ROLE_USER'){
            return $this->redirectToRoute('home');
        }else{
            $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

            return $this->redirect($routeBuilder->setController(EvenementCrudController::class)->generateUrl());
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace d\'administration')
            ->setFaviconPath("media/favicon/android-chrome-512x512.png")
            ->setTextDirection('ltr');
    }

    public function configureMenuItems(): iterable
    {
        return [
            yield MenuItem::linktoDashboard('Home', 'fa fa-home'),

            yield MenuItem::section('Utilisateurs'),
            yield MenuItem::subMenu('Profils', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Utilsateurs', 'fas fa-project-diagram', User::class),
            ]),
            yield MenuItem::subMenu('Gestion événement', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Evénement', 'fas fa-calendar-alt', Evenement::class),
                MenuItem::linkToCrud('Sport', 'fas fa-futbol', Sport::class),
                MenuItem::linkToCrud('Type', 'fas fa-project-diagram', Type::class),
                MenuItem::linkToCrud('Catégorie', 'fas fa-project-diagram', Categorie::class),
            ]),
            yield MenuItem::subMenu('Gestion document', 'fa fa-tasks')->setSubItems([
                MenuItem::linkToCrud('Document', 'fas fa-project-diagram', Document::class),
                MenuItem::linkToCrud('Catégorie des documents', 'fas fa-project-diagram', DocumentCategorie::class),
            ]),
            yield MenuItem::linktoRoute('Retour au site', 'fas fa-backward', 'home'),
            yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt'),
        ];
    }
}
