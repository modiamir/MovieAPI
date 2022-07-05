<?php

namespace App\Domain\Movie\Action;

use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Repository\MovieRepositoryInterface;

class GetSingleMovieAction
{
    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    public function get(int $int): ?Movie
    {
        return $this->movieRepository->findById($int);
    }
}
