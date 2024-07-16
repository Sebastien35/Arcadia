<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class MailerService
{
    
    public function __construct(
        #[Autowire('%admin_email%')] private string $adminEmail,
        private readonly MailerInterface $mailer
    )
    {
        $this->adminEmail = $adminEmail;
        
    }

    public function sendWelcomeEmail(string $to, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('Bienvenue chez Arcadia!')
            ->htmlTemplate('emails/welcome_email.html.twig')
            ->context($context);
        $this->mailer->send($email);
    }
    
    public function sendResponseMail(string $to, string $text): void
    {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('Réponse à votre demande')
            ->text($text);
            
        $this->mailer->send($email);
    }

}