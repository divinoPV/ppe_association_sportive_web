<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error= $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/registration', name: 'registration')]
    public function registration(EntityManagerInterface $manager,
                                 Request $request,
                                 UserPasswordEncoderInterface $encoder
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPlainPassword());
            $user
                ->addRoles()
                ->setPassword($hash)
                ->setCreer(new \DateTime('now'))
                ->setModifier(new \DateTime('now'))
            ;
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('security/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }


    #[Route("/logout", name: "logout")]
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    #[Route('/forgotten', name: 'forgotten')]
    public function forgottenPassword(AuthenticationUtils $authenticationUtils,
                                      EntityManagerInterface $em,
                                      MailerInterface $mailer,
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
                $transport = Transport::fromDsn("gmail://montestpoursf@gmail.com:Test1234%2B@default");
                $mailer = new Mailer($transport);
                $email = (new TemplatedEmail())
                    ->from($user)
                    ->to($admin->getEmail())
                    ->subject("Changement de mot de passe")
                    ->htmlTemplate("contact_forgotten.html.twig")
                    ->context([
                        "e_mail" => $user,
                        "message" => $message
                    ])
                ;

                $loader = new FilesystemLoader("emails\\");
                $twigEnv = new Environment($loader);
                $twigBodyRenderer = new BodyRenderer($twigEnv);
                $twigBodyRenderer->render($email);
                //On envoie le mail
                $mailer->send($email);
                //On confirme et on redirige
                $this->addFlash("message", "Votre e-mail a bien été envoyé !");

                return $this->redirectToRoute("login");
            endif;
        endif;

        return $this->render('security/forgotten.html.twig', [
            "title" => $title,
            "error" => $error ?? null,
        ]);
    }
}
