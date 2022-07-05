<?php

namespace App\Tests\Domain\Movie\Action;

use App\Domain\Movie\Action\GetMovieListAction;
use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Repository\MovieRepositoryInterface;
use App\Factory\MovieFactory;
use App\Tests\UnitTestCase;

class GetMovieListActionTest extends UnitTestCase
{
    function test_get()
    {
        // Arrange
        $movieRepository = \Mockery::mock(MovieRepositoryInterface::class);
        $action = new GetMovieListAction($movieRepository);

        /** @var Movie $movie */
        $movie = MovieFactory::new()->withoutPersisting()->create()->object();

        // Expect
        $movieRepository->shouldReceive('findByOwner')->with($movie->getOwner())->andReturn([$movie]);

        // Ac
        $result = $action->get($movie->getOwner());

        // Assert
        $this->assertEquals([$movie], $result);
        $movieRepository->shouldHaveReceived('findByOwner')->with($movie->getOwner())->once();
    }
}
