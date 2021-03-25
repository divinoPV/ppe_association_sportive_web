<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Evenement;
use App\Entity\Inscription;
use App\Form\EvenementSearchType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,
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

            $data = $this
                ->getDoctrine()
                ->getRepository(Evenement::class)
                ->searchEvenement($criteria);

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
     * @param int $id
     * @return Response
     */
    public function single(int $id): Response
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

        $event = $this
            ->getDoctrine()
            ->getRepository(Evenement::class)
            ->findOneBy(["id" => $id]);

        $hasRegister = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->findOneBy(["evenement" => $id, "utilisateur" => $this->getUser()->getId()]);

        $hasRegister > 0 ? $hasRegister = true : $hasRegister = false;

        return $this->render('evenement/single.html.twig', [
            'event' => $event,
            'hasRegister' => $hasRegister,
            'inscriptionCount' => $countInscription,
            'documentCount' => $countDocument,
            'documents' => $documents,
        ]);
    }

    /**
     * @Route("/{id}/registration", name=self::ROUTE_REGISTRATION)
     * @param EntityManagerInterface $em
     * @param int $id
     * @return Response
     */
    public function registration(EntityManagerInterface $em,
                                 int $id
    ): Response
    {
        /** @var Evenement $event */
        $event = $this
            ->getDoctrine()
            ->getRepository(Evenement::class)
            ->findOneBy(["id" => $id]);

        /** @var Inscription $checkInscription */
        $checkInscription = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->findOneBy(["evenement" => $id, "utilisateur" => $this->getUser()->getId()]);

        if ($checkInscription > 0):
            $insc = new Inscription();
            $insc->setUtilisateur($this->container->get('security.token_storage')->getToken()->getUser())
                ->setEvenement($event)
                ->setCreerLe();

            $em->persist($insc);
            $em->flush();
        else:
            $err = "Une erreur inconnue est survenue !";
        endif;

        return $this->render(self::TEMPLATE . '/registration.html.twig', [
            'event' => $event,
            'message' => $err ?? "Félicitation ! Votre inscription c'est bien passée."
        ]);
    }
}
