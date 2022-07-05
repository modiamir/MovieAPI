<?php

namespace App\Tests\Controller\Movie;

use App\Factory\CastFactory;
use App\Factory\MovieFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\ApplicationTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetMovieListControllerTest extends ApplicationTestCase
{
    private const ROUTE = '/api/v1/movies';

    function test_successful()
    {
        // Arrange
        $client = self::createClient();
        $movies = MovieFactory::createMany(2, [
            'casts' => CastFactory::new()->many(1),
            'ratings' => RatingFactory::new()->many(1),
        ]);

        $expectedResponseBody = [
            [
                'id' => $movies[0]->getId(),
                'name' => $movies[0]->getName(),
                'casts' => [$movies[0]->getCasts()->first()->getName()],
                'release_date' => $movies[0]->getReleaseDate()->format('d-m-Y'),
                'director' => $movies[0]->getDirector(),
                'ratings' => [
                    $movies[0]->getRatings()->first()->getPlatformName() => $movies[0]->getRatings()->first()->getRate()
                ],
            ]
        ];

        // Act
        $client->jsonRequest(
            'GET',
            self::ROUTE,
            [],
            ['HTTP_Authorization' => "Bearer {$movies[0]->getOwner()->getAccessToken()}"]
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseFormatSame('json');
        $this->assertEquals($expectedResponseBody, json_decode($client->getResponse()->getContent(), true));
    }

    function test_unauthorized()
    {
        // Arrange
        $client = self::createClient();

        // Act
        $client->jsonRequest(
            'GET',
            self::ROUTE,
            [],
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
