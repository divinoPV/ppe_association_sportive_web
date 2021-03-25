<?php

namespace App\Service\Mail;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailSender extends AbstractController
{
    public static function sendMail(MailerInterface $mailer, String $mailEmetteur, string $mailReceveur, String $template, Array $option): bool
    {
        $email = (new TemplatedEmail())
            ->from($mailEmetteur)
            ->to($mailReceveur)
            ->subject($option['sujet'])
            ->htmlTemplate($template)
            ->context([
                'option' => $option,
            ]);

        try {
            $mailer->send($email);

            return true;
        } catch (TransportExceptionInterface $e) {
            return false;
        }
    }
}