<?php

namespace App\Domain\Movie\Service;

use App\Domain\Movie\Entity\Movie;

interface MoviePersistenceServiceInterface
{
    public function save(Movie $movie): void;
}
