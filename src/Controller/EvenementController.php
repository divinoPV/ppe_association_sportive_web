<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Evenement;
use App\Entity\Inscription;
use App\Form\EvenementSearchType;
use App\Repository\EvenementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     * @param Request $request
     * @param EvenementRepository $evenementRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,
                          EvenementRepository $evenementRepository,
                          PaginatorInterface $paginator
    ): Response
    {
        $countEvent = $this
            ->getDoctrine()
            ->getRepository(Evenement::class)
            ->countEvent();

        $countInscription = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->inscriptionToEvent();

        $data = $this
            ->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();

        $events = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            5
        );

        $searchEventForm = $this->createForm(EvenementSearchType::class);

        if ($searchEventForm->handleRequest($request)->isSubmitted() &&
            $searchEventForm->isValid()
        ):
            $criteria = $searchEventForm->getData();
            $result = $evenementRepository->searchEvenement($criteria);
        endif;

        return $this->render('evenement/index.html.twig', [
            'events' => $result ?? $events,
            'eventCount' => $countEvent[0][1],
            'inscriptionCount' => $countInscription,
            'search_event_form' => $searchEventForm->createView()
        ]);
    }

    /**
     * @Route("/evenement/{id}", name="single_event")
     * @param EvenementRepository $evenementRepository
     * @param int $id
     * @return Response
     */
    public function single(EvenementRepository $evenementRepository, int $id): Response
    {
        $countInscription = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->inscriptionToEvent();

        $countDocument = $this
            ->getDoctrine()
            ->getRepository(Document::class)
            ->countDocument();

        $documents = $this
            ->getDoctrine()
            ->getRepository(Document::class)
            ->allDocument();

        return $this->render('evenement/single.html.twig', [
            'event' => $evenementRepository->findBy(["id" => $id])[0],
            'inscriptionCount' => $countInscription,
            'documentCount' => $countDocument,
            'documents' => $documents,
        ]);
    }
}
