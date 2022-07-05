<?php

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;

class AccessTokenService
{
    public function __construct(private readonly UniqueTokenGeneratorInterface $uniqueTokenGenerator)
    {
    }

    public function generateAndSet(User $user): void
    {
        $user->setAccessToken($this->uniqueTokenGenerator->generate());
    }
}
