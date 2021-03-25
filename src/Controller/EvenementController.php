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

/**
 * @Route("/evenement")
 */
final class EvenementController extends AbstractController
{
    public const TEMPLATE = 'evenement';
    /** ROUTE NAME */
    public const ROUTE_SINGLE = self::TEMPLATE . "_single";
    public const ROUTE_REGISTRATION = self::TEMPLATE . "_registration";

    /**
     * @Route("/", name=self::TEMPLATE)
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

        $searchEventForm = $this->createForm(EvenementSearchType::class, null, [
            'action' => $this->generateUrl('evenement'),
            'method' => 'GET',
        ]);

        if ($searchEventForm->handleRequest($request)->isSubmitted() &&
            $searchEventForm->isValid()
        ):
            $criteria = $searchEventForm->getData();
            $data = $evenementRepository->searchEvenement($criteria);

            $result = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                5
            );
        endif;

        return $this->render(self::TEMPLATE . '/index.html.twig', [
            'events' => $result ?? $events,
            'eventCount' => $countEvent[0][1],
            'inscriptionCount' => $countInscription,
            'search_event_form' => $searchEventForm->createView()
        ]);
    }

    /**
     * @Route("/{id}", name=self::ROUTE_SINGLE)
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

    /**
     * @Route("/{id}/registration", name=self::ROUTE_REGISTRATION)
     * @param EvenementRepository $evenementRepository
     * @param int $id
     * @return Response
     */
    public function registration(EvenementRepository $evenementRepository, int $id): Response
    {
        return $this->render(self::TEMPLATE . '/registration.html.twig', [
            'event' => $evenementRepository->findBy(["id" => $id])[0],
        ]);
    }
}
