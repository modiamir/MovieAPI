<?php

namespace App\Domain\Movie\Action;

use App\Domain\Movie\DTO\CreateMovieDTO;
use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Service\MovieCreator;
use App\Domain\Movie\Service\MoviePersistenceServiceInterface;
use App\Domain\User\Entity\User;

class CreateMovieAction
{
    public function __construct(
        private readonly MovieCreator $movieCreator,
        private readonly MoviePersistenceServiceInterface $moviePersistenceService
    ) {
    }

    public function create(CreateMovieDTO $dto, User $user): Movie
    {
        $movie = $this->movieCreator->createFromDTO($dto, $user);
        $this->moviePersistenceService->save($movie);

        return $movie;
    }
}
