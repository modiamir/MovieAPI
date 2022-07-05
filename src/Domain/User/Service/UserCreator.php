<?php

namespace App\Domain\User\Service;

use App\Domain\User\DTO\RegisterUserDTO;
use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreator
{
    public function __construct(private readonly UserPasswordService $userPasswordService)
    {
    }

    public function createFromDTO(RegisterUserDTO $registerUserDTO): User
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setEmail($registerUserDTO->email);
        $this->userPasswordService->hashAndSet($user, $registerUserDTO->password);

        return $user;
    }
}
