<?php

namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager ): Response
    {
        $events = $manager
            ->getRepository(Evenement::class)
            ->lastEvenements();
        return $this->render('home/index.html.twig', [
            'events' => $events,
        ]);
    }
}
