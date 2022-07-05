<?php

namespace App\Domain\User\Action;

use App\Domain\User\DTO\AuthenticateUserDTO;
use App\Domain\User\DTO\AuthenticationResultDTO;
use App\Domain\User\Exception\AuthenticationFailedException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\AccessTokenService;
use App\Domain\User\Service\UserPasswordService;
use App\Domain\User\Service\UserPersistenceServiceInterface;

class AuthenticateUserAction
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPersistenceServiceInterface $userPersistenceService,
        private readonly UserPasswordService $userPasswordService,
        private readonly AccessTokenService $accessTokenService,
    ) {
    }

    public function authenticate(AuthenticateUserDTO $dto): AuthenticationResultDTO
    {
        $user = $this->userRepository->findOneByEmail($dto->email);

        if (is_null($user) || !$this->userPasswordService->isValid($user, $dto->password)) {
            throw new AuthenticationFailedException();
        }

        $this->accessTokenService->generateAndSet($user);
        $this->userPersistenceService->save($user);

        return new AuthenticationResultDTO($user->getAccessToken());
    }
}
