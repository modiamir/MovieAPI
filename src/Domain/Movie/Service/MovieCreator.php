<?php

namespace App\Domain\Movie\Service;

use App\Domain\Movie\DTO\CreateMovieDTO;
use App\Domain\Movie\Entity\Cast;
use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Entity\Rating;
use App\Domain\User\Entity\User;

class MovieCreator
{
    public function __construct()
    {
    }

    public function createFromDTO(CreateMovieDTO $dto, User $user)
    {
        $movie = new Movie();
        $movie->setName($dto->name);
        $movie->setReleaseDate(\DateTime::createFromFormat('d-m-Y', $dto->releaseDate));
        $movie->setDirector($dto->director);
        $movie->setOwner($user);

        foreach ($dto->casts as $castName) {
            $cast = new Cast();
            $cast->setName($castName);
            $movie->addCast($cast);
        }

        foreach ($dto->ratings as $platformName => $rate) {
            $rating = new Rating();
            $rating->setPlatformName($platformName);
            $rating->setRate($rate);
            $movie->addRating($rating);
        }

        return $movie;
    }
}
