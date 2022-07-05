<?php

namespace App\Domain\User\Action;

use App\Domain\User\DTO\RegisterUserDTO;
use App\Domain\User\Entity\User;
use App\Domain\User\Exception\UserEmailDuplicateException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserCreator;
use App\Domain\User\Service\UserPersistenceServiceInterface;

class RegisterUserAction
{
    public function __construct(
        private readonly UserPersistenceServiceInterface $userPersistenceService,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserCreator $userCreator
    ) {
    }

    public function register(RegisterUserDTO $registerUserDTO): User
    {
        if ($this->userRepository->findOneByEmail($registerUserDTO->email)) {
            throw new UserEmailDuplicateException();
        }
        $user = $this->userCreator->createFromDTO($registerUserDTO);
        $this->userPersistenceService->save($user);

        return $user;
    }
}
