<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(EntityManagerInterface $manager): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('login');
        }

        $events = $manager
            ->getRepository(Evenement::class)
            ->lastEvenements();

        $countInscription = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->inscriptionToEvent();

        return $this->render('home/index.html.twig', [
            'events' => $events,
            'inscriptionCount' => $countInscription
        ]);
    }
}
