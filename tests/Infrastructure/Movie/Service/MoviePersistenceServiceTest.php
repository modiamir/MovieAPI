<?php

namespace App\Tests\Infrastructure\Movie\Service;

use App\Domain\Movie\Entity\Movie;
use App\Factory\MovieFactory;
use App\Infrastructure\Movie\Repository\MovieRepository;
use App\Infrastructure\Movie\Service\MoviePersistenceService;
use App\Tests\IntegrationTestCase;

class MoviePersistenceServiceTest extends IntegrationTestCase
{
    function test_saving_a_new_movie()
    {
        // Arrange
        /** @var Movie $movie */
        $movie = MovieFactory::new()->withoutPersisting()->create()->object();

        /** @var MoviePersistenceService $service */
        $service = self::getContainer()->get(MoviePersistenceService::class);

        /** @var MovieRepository $repository */
        $repository = self::getContainer()->get(MovieRepository::class);

        // Act
        $service->save($movie);

        // Assert
        $this->assertNotNull($repository->findOneBy(['name' => $movie->getName()]));
    }
}
