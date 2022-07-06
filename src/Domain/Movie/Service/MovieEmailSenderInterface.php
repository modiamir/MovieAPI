<?php

namespace App\Domain\Movie\Service;

interface MovieEmailSenderInterface
{
    public function sendEmail(string $subject, string $to, string $body): void;
}
