<?php

namespace App\Domain\Movie\Repository;

use App\Domain\Movie\Entity\Movie;
use App\Domain\User\Entity\User;

interface MovieRepositoryInterface
{
    public function findById(int $id): ?Movie;

    /**
     * @return Movie[]
     */
    public function findByOwner(User $user): array;
}
