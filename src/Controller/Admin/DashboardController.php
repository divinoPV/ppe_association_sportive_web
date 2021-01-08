<?php

namespace App\Controller\Admin;

use App\Entity\User;
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
        if($this->getUser()->getRoles() === 'ROLE_USER'){
            return $this->redirectToRoute('home');
        }else{
            return parent::index();
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
                MenuItem::linkToCrud('Rénitialisation mot de passe', 'fas fa-layer-group', User::class),
            ]),
            yield MenuItem::linktoRoute('Retour au site', 'fas fa-backward', 'home'),
            yield MenuItem::linkToLogout('Logout', 'fas fa-sign-out-alt'),
        ];
    }
}
