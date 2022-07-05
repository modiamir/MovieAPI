<?php

namespace App\Domain\User\DTO;

class AuthenticationResultDTO
{
    public function __construct(public string $token)
    {
    }
}
