<?php

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPasswordService
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function isValid(User $user, string $password)
    {
        return $this->userPasswordHasher->isPasswordValid($user, $password);
    }

    public function hashAndSet(User $user, ?string $password): void
    {
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
    }
}
