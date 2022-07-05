<?php

namespace App\Service\Movie;

use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Service\MoviePersistenceServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class MoviePersistenceService implements MoviePersistenceServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Movie $movie): void
    {
        $this->entityManager->persist($movie);
        $this->entityManager->flush();
    }
}
