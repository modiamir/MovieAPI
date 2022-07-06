<?php

namespace App\Domain\Movie\Service;

use App\Domain\Movie\Entity\Movie;

class MovieEmailService
{
    public function __construct(private readonly MovieEmailSenderInterface $emailSender)
    {
    }

    public function sendEmailToCreatedMovieOwner(Movie $movie): void
    {
        $this->emailSender->sendEmail(
            "Movie created.",
            $movie->getOwner()->getEmail(),
            "Movie with name '{$movie->getName()}' created"
        );
    }
}
