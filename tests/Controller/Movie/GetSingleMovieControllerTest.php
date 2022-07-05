<?php

namespace App\Tests\Controller\Movie;

use App\Factory\CastFactory;
use App\Factory\MovieFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\ApplicationTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetSingleMovieControllerTest extends ApplicationTestCase
{
    private const ROUTE = '/api/v1/movies/%s';

    function test_successful()
    {
        // Arrange
        $client = self::createClient();
        $movie = MovieFactory::createOne([
            'casts' => CastFactory::new()->many(1),
            'ratings' => RatingFactory::new()->many(1),
        ]);

        $expectedResponseBody = [
            'name' => $movie->getName(),
            'casts' => [$movie->getCasts()->first()->getName()],
            'release_date' => $movie->getReleaseDate()->format('d-m-Y'),
            'director' => $movie->getDirector(),
            'ratings' => [$movie->getRatings()->first()->getPlatformName() => $movie->getRatings()->first()->getRate()],
        ];

        // Act
        $client->jsonRequest(
            'GET',
            sprintf(self::ROUTE, $movie->getId()),
            [],
            ['HTTP_Authorization' => "Bearer {$movie->getOwner()->getAccessToken()}"]
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseFormatSame('json');
        $this->assertEquals($expectedResponseBody, json_decode($client->getResponse()->getContent(), true));
    }

    function test_forbidden()
    {
        // Arrange
        $client = self::createClient();
        $movie = MovieFactory::createOne([
            'casts' => CastFactory::new()->many(1),
            'ratings' => RatingFactory::new()->many(1),
        ]);
        $currentUser = UserFactory::createOne()->object();

        // Act
        $client->jsonRequest(
            'GET',
            sprintf(self::ROUTE, $movie->getId()),
            [],
            ['HTTP_Authorization' => "Bearer {$currentUser->getAccessToken()}"]
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    function test_not_found()
    {
        // Arrange
        $client = self::createClient();
        $currentUser = UserFactory::createOne()->object();

        // Act
        $client->jsonRequest(
            'GET',
            sprintf(self::ROUTE, 0),
            [],
            ['HTTP_Authorization' => "Bearer {$currentUser->getAccessToken()}"]
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    function test_unauthorized()
    {
        // Arrange
        $client = self::createClient();
        $movie = MovieFactory::createOne([
            'casts' => CastFactory::new()->many(1),
            'ratings' => RatingFactory::new()->many(1),
        ]);

        // Act
        $client->jsonRequest(
            'GET',
            sprintf(self::ROUTE, $movie->getId()),
            [],
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
