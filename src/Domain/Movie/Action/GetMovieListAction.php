<?php

namespace App\Domain\Movie\Action;

use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Repository\MovieRepositoryInterface;
use App\Domain\User\Entity\User;

class GetMovieListAction
{
    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    /**
     * @return Movie[]
     */
    public function get(User $owner): array
    {
        return $this->movieRepository->findByOwner($owner);
    }
}
