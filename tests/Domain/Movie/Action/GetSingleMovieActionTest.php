<?php

namespace App\Tests\Domain\Movie\Action;

use App\Domain\Movie\Action\GetSingleMovieAction;
use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Repository\MovieRepositoryInterface;
use App\Factory\MovieFactory;
use App\Tests\UnitTestCase;

class GetSingleMovieActionTest extends UnitTestCase
{
    function test_get_existing_movie()
    {
        // Arrange
        $movieRepository = \Mockery::mock(MovieRepositoryInterface::class);
        $action = new GetSingleMovieAction($movieRepository);

        /** @var Movie $movie */
        $movie = MovieFactory::new()->withoutPersisting()->create()->object();

        // Expect
        $movieRepository->shouldReceive('findById')->with(1)->andReturn($movie);

        // Ac
        $result = $action->get(1);

        // Assert
        $this->assertEquals($movie, $result);
        $movieRepository->shouldHaveReceived('findById')->with(1)->once();
    }

    function test_get_null_for_non_existing_movie()
    {
        // Arrange
        $movieRepository = \Mockery::mock(MovieRepositoryInterface::class);
        $action = new GetSingleMovieAction($movieRepository);

        // Expect
        $movieRepository->shouldReceive('findById')->with(1)->andReturn(null);

        // Ac
        $result = $action->get(1);

        // Assert
        $this->assertNull($result);
        $movieRepository->shouldHaveReceived('findById')->with(1)->once();
    }
}
