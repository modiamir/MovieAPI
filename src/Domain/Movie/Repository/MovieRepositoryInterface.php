<?php

namespace App\Domain\Movie\Repository;

use App\Domain\Movie\Entity\Movie;

interface MovieRepositoryInterface
{
    public function findById(int $id): ?Movie;
}
