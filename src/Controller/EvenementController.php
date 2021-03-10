<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementSearchType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param EvenementRepository $evenementRepository
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(EntityManagerInterface $manager,
                          Request $request,
                          EvenementRepository $evenementRepository
    ): Response
    {
        $eventQB = $manager
            ->createQueryBuilder()
            ->select('count(e.id)')
            ->from('App:Evenement', 'e');
        $eventCount = $eventQB->getQuery()->getSingleScalarResult();

        $inscriptionQB = $manager
            ->createQueryBuilder()
            ->select('count(i.evenement), e.id')
            ->from('App:Inscription', 'i')
            ->join('App:Evenement', 'e')
            ->where('e.id = i.evenement')
            ->groupBy('i.evenement')
        ;
        $inscriptionCount = $inscriptionQB->getQuery()->getResult();

        $events = $manager
            ->getRepository(Evenement::class)
            ->findAll();

        $searchEventForm = $this->createForm(EvenementSearchType::class);

        if ($searchEventForm->handleRequest($request)->isSubmitted() &&
            $searchEventForm->isValid()
        ):
            $criteria = $searchEventForm->getData();
            $result = $evenementRepository->searchEvenement($criteria);
        endif;

        return $this->render('evenement/index.html.twig', [
            'events' => $result ?? $events,
            'eventCount' => $eventCount,
            'inscriptionCount' => $inscriptionCount,
            'search_event_form' => $searchEventForm->createView()
        ]);
    }
}
