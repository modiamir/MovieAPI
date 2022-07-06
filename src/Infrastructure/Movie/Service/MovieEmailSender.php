<?php

namespace App\Infrastructure\Movie\Service;

use App\Domain\Movie\Service\MovieEmailSenderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MovieEmailSender implements MovieEmailSenderInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendEmail(string $subject, string $to, string $body): void
    {
        $email = (new Email())
            ->from('noreply@movie.api')
            ->to($to)
            ->subject($subject)
            ->text($body)
            ->html("<p>$body</p>");

        $this->mailer->send($email);
    }
}
