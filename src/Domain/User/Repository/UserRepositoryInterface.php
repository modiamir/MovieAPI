<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function findOneByEmail(string $email): ?User;
    public function findOneByAccessToken(string $accessToken): ?User;
}
