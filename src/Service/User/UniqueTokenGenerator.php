<?php

namespace App\Service\User;

use App\Domain\User\Service\UniqueTokenGeneratorInterface;

class UniqueTokenGenerator implements UniqueTokenGeneratorInterface
{
    public function generate(): string
    {
        return uniqid();
    }
}
