<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\User;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="profile")
     */
    public function profil(User $user, Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager): Response
    {
        if (($user !== $this->getUser()) || ($this->getUser() === null) ) {
            return $this->redirectToRoute('home');
        }

        $inscriptions = $this
            ->getDoctrine()
            ->getRepository(Inscription::class)
            ->findBy(['utilisateur' => $user]);

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPlainPassword()) {
                $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
            }

            $user->setModifierLe(new \DateTime());

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profile',['id' => $user->getId()]);
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'inscriptions' => $inscriptions,
            'form' => $form->createView(),
        ]);
    }
}
