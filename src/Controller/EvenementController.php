<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'evenement')]
    public function index(EntityManagerInterface $manager,
                          Request $request
    ): Response
    {
        $qb = $manager
            ->createQueryBuilder()
            ->select('count(event.id)')
            ->from('App:Evenement', 'event');
        $count = $qb->getQuery()->getSingleScalarResult();

        $events = $manager
            ->getRepository(Evenement::class)
            ->findAll();

        $searchEventForm = $this->createForm(EvenementSearchType::class);


        return $this->render('evenement/index.html.twig', [
            'events' => $events,
            'count' => $count,
            'search_event_form' => $searchEventForm->createView()
        ]);
    }
}
