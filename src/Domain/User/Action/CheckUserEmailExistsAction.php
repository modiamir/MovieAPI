<?php

namespace App\Domain\User\Action;

use App\Domain\User\Repository\UserRepositoryInterface;

class CheckUserEmailExistsAction
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function check(string $email)
    {
        return !is_null($this->userRepository->findOneByEmail($email));
    }
}
