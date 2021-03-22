<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SecurityController extends AbstractController
{
    /*#[Route('/login', name: 'login')]*/
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
            'error' => $error
        ]);
    }

    /*#[Route('/registration', name: 'registration')]*/
    /**
     * @Route("/registration", name="registration")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(EntityManagerInterface $manager,
                                 Request $request,
                                 UserPasswordEncoderInterface $encoder
    ): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPlainPassword());
            $user
                ->setRoles('ROLE_USER')
                ->setPassword($hash)
                ->setCreer(new DateTime('now'))
                ->setModifier(new DateTime('now'));
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home',);
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /*#[Route("/logout", name: "logout")]*/
    /**
     * @Route("/logout", name="logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /*#[Route('/forgotten', name: 'forgotten')]*/
    /**
     * @Route("/forgotten", name="forgotten")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function forgottenPassword(EntityManagerInterface $em,
                                      Request $request
    ): Response
    {
        $title = " - Mot de passe oublié";

        if (!empty($request->get("submit"))):
            $admin = $em->getRepository(User::class)->findUsersByRole("ROLE_ADMIN");
            $user = $request->get("fogetten_password_first");
            $data = $em->getRepository(User::class)->findOneBy([
                "email" => $user
            ]);

            if ($request->get("fogetten_password_first") !== $request->get("fogetten_password_second")):
                $error = "Les adresses ne correpondent pas !";
            elseif (empty($data)):
                $error = "L'adresse mail n'est lié à aucun compte !";
            else:
                $message = <<<EOT
                                <p>Message automatique pour la demande de changement de mot passe.</p>
                                </br>
                                <p>Vous pouvez modifié ici : https://localhost:8000/admin</p>
                       EOT;
                //On créé le mail
                $transport = Transport::fromDsn($_ENV["MAILER_DSN"]);
                $mailer = new Mailer($transport);
                $email = (new TemplatedEmail())
                    ->from($user)
                    ->to($admin->getEmail())
                    ->subject("Changement de mot de passe")
                    /*
                        Obliger de mettre le template html dans le public car le site pointe
                        dans le dossier public, la méthode htmlTemplate() est sécurisé et ne
                        permet pas de remonter dans l'architecture et d'accéder au dossier template.
                    */
                    ->htmlTemplate("contact_forgotten.html.twig")
                    ->context([
                        "e_mail" => $user,
                        "message" => $message
                    ]);

                $loader = new FilesystemLoader("emails\\");
                $twigEnv = new Environment($loader);
                $twigBodyRenderer = new BodyRenderer($twigEnv);
                $twigBodyRenderer->render($email);
                //On envoie le mail
                $mailer->send($email);
                //On confirme et on redirige
                $this->addFlash("message", "Votre e-mail a bien été envoyé !");

                $data->setForgottenPassword(true);

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
