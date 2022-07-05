<?php

namespace App\Tests\Domain\Movie;

use App\Domain\Movie\Action\CreateMovieAction;
use App\Domain\Movie\DTO\CreateMovieDTO;
use App\Domain\Movie\Entity\Cast;
use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Entity\Rating;
use App\Domain\Movie\Service\MovieCreator;
use App\Domain\Movie\Service\MoviePersistenceServiceInterface;
use App\Factory\UserFactory;
use App\Tests\UnitTestCase;
use Hamcrest\Core\IsEqual;

class CreateMovieActionTest extends UnitTestCase
{
    function test_create()
    {
        // Arrange
        $dto = new CreateMovieDTO(
            name: self::faker()->word(),
            releaseDate: self::faker()->date('d-m-Y'),
            director: sprintf("%s %s", self::faker()->name(), self::faker()->name()),
            casts: self::faker()->words(1),
            ratings: [
                "imdb" => self::faker()->randomFloat(2, max: 10),
            ],
        );
        $owner = UserFactory::new()->withoutPersisting()->create()->object();

        $movieCreator = new MovieCreator();
        $moviePersistenceService = \Mockery::spy(MoviePersistenceServiceInterface::class);
        $action = new CreateMovieAction($movieCreator, $moviePersistenceService);

        // Act
        $result = $action->create($dto, $owner);

        // Assert
        $this->assertInstanceOf(Movie::class, $result);
        $this->assertEquals($dto->name, $result->getName());
        $this->assertEquals($dto->director, $result->getDirector());
        $this->assertEquals(\DateTime::createFromFormat('d-m-Y', $dto->releaseDate), $result->getReleaseDate());
        $this->assertEquals($dto->casts[0], $result->getCasts()->first()->getName());
        $this->assertEquals("imdb", $result->getRatings()->first()->getPlatformName());
        $this->assertEquals($dto->ratings["imdb"], $result->getRatings()->first()->getRate());
        $this->assertEquals($owner, $result->getOwner());

        $moviePersistenceService->shouldHaveReceived('save')->with(IsEqual::equalTo($result));
    }
}
