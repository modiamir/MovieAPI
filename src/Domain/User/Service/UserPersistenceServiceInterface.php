<?php

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;

interface UserPersistenceServiceInterface
{
    public function save(User $user): void;
}
