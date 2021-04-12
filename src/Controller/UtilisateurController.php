<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="profil")
     */
    public function profil(User $user): Response
    {
        $inscriptions = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->findBy(['utilisateur' => $user]);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'inscriptions' => $inscriptions,
        ]);
    }
}
