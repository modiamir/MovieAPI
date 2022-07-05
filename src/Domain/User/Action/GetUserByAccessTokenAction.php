<?php

namespace App\Domain\User\Action;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;

class GetUserByAccessTokenAction
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function get(string $accessToken): ?User
    {
        return $this->userRepository->findOneByAccessToken($accessToken);
    }
}
