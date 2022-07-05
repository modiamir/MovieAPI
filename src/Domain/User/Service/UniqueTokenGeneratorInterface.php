<?php

namespace App\Domain\User\Service;

interface UniqueTokenGeneratorInterface
{
    public function generate(): string;
}
