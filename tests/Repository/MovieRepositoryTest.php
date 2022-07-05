<?php

namespace App\Tests\Repository;

use App\Factory\CastFactory;
use App\Factory\MovieFactory;
use App\Factory\RatingFactory;
use App\Repository\MovieRepository;
use App\Tests\IntegrationTestCase;

class MovieRepositoryTest extends IntegrationTestCase
{
    function test_fetching_an_existing_movie_by_id()
    {
        // Arrange
        $movie = MovieFactory::createOne();

        /** @var MovieRepository $repository */
        $repository = self::getContainer()->get(MovieRepository::class);

        // Act
        $result = $repository->findById($movie->getId());

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($movie->getId(), $result->getId());
    }

    function test_fetching_a_non_existing_movie_by_id()
    {
        // Arrange
        /** @var MovieRepository $repository */
        $repository = self::getContainer()->get(MovieRepository::class);

        // Act
        $result = $repository->findById(self::faker()->randomNumber());

        // Assert
        $this->assertNull($result);
    }

    function test_fetching_existing_movies_by_owner()
    {
        // Arrange
        $movies = MovieFactory::createMany(2, [
            'casts' => CastFactory::new()->many(1),
            'ratings' => RatingFactory::new()->many(1),
        ]);

        /** @var MovieRepository $repository */
        $repository = self::getContainer()->get(MovieRepository::class);

        // Act
        $result = $repository->findByOwner($movies[0]->getOwner());

        // Assert
        $this->assertNotNull($result);
        $this->assertCount(1, $result);
        $this->assertEquals($movies[0]->getId(), $result[0]->getId());
    }
}
