<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Service\Mail\EmailSender;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
        'demande' => $message ?? null
        ]);
    }

    /**
     * @Route("/registration", name="registration")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(EntityManagerInterface $manager,
                                 Request $request,
                                 UserPasswordEncoderInterface $encoder,
                                 MailerInterface $mailer
    ): Response
    {
        $user = new User();

        /** @var User $admin */
        $admin = $manager->getRepository(User::class)->getUserByRole('ROLE_ADMIN');
        $form = $this->createForm(InscriptionType::class, $user,[
            'validation_groups' => ['Default','inscription'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPlainPassword());
            $user
                ->setRoles('ROLE_USER')
                ->setPassword($hash)
                ->setCreerLe(new DateTime('now'))
                ->setModifierLe(new DateTime('now'));

            $option = [
                'sujet' => 'Demande d\'inscription',
                'utilisateur' => $user,
                'administrateur' => $admin
            ];
            EmailSender::sendMail($mailer, $user->getEmail(), $admin->getEmail(), 'email/contact_register.html.twig', $option);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/forgotten", name="forgotten")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     */
    public function forgottenPassword(EntityManagerInterface $em, Request $request, MailerInterface $mailer): Response
    {
        $title = " - Mot de passe oublié";

        if (!empty($request->get("submit"))):
            $admin = $em->getRepository(User::class)->getUserByRole('ROLE_ADMIN');
            $user = $request->get("fogetten_password_first");
            $data = $em->getRepository(User::class)->findOneBy([
                "email" => $user
            ]);

            if ($request->get("fogetten_password_first") !== $request->get("fogetten_password_second")):
                $error = "Les adresses ne correpondent pas !";

            elseif (empty($data)):
                $error = "L'adresse mail n'est lié à aucun compte !";

            else:
                $option = [
                    'sujet' => 'Demande de modification de mot de passe',
                    'utilisateur' => $user,
                    'administrateur' => $admin
                ];

                EmailSender::sendMail($mailer, $user, $admin->getEmail(), 'email/contact_forgotten.html.twig', $option);

                $data->setMdpOublier(true);

                $em->persist($data);
                $em->flush();

                return $this->redirectToRoute("login");
            endif;
        endif;

        return $this->render('security/forgotten.html.twig', [
            "title" => $title,
            "error" => $error ?? null,
        ]);
    }
}
