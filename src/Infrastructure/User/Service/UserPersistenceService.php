<?php

namespace App\Infrastructure\User\Service;

use App\Domain\User\Entity\User;
use App\Domain\User\Service\UserPersistenceServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserPersistenceService implements UserPersistenceServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
