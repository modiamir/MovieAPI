<?php

namespace App\Tests\Controller\Movie;

use App\Domain\User\Entity\User;
use App\Factory\UserFactory;
use App\Repository\MovieRepository;
use App\Tests\ApplicationTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateMovieControllerTest extends ApplicationTestCase
{
    private const ROUTE = '/api/v1/movies';

    function test_successful()
    {
        // Arrange
        $data = [
            "name" => self::faker()->word(),
            "casts" => self::faker()->words(2),
            "release_date" => self::faker()->date('d-m-Y'),
            "director" => sprintf("%s %s", self::faker()->name(), self::faker()->name()),
            "ratings" => [
                "imdb" => self::faker()->randomFloat(2, max: 10),
                "rotten_tomatoes" => self::faker()->randomFloat(2, max: 10),
            ],
        ];

        $client = self::createClient();
        /** @var User $creator */
        $creator = UserFactory::createOne()->object();

        $repository = self::getContainer()->get(MovieRepository::class);

        // Act
        $client->jsonRequest(
            'POST',
            self::ROUTE,
            $data,
            ['HTTP_Authorization' => "Bearer {$creator->getAccessToken()}"]
        );

        // Assert
        $createdMovie = $repository->findOneBy(['name' => $data['name']]);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertNotNull($createdMovie);
        $this->assertEquals($creator, $createdMovie->getOwner());
    }

    function test_unauthorized()
    {
        // Arrange
        $data = [
            "name" => self::faker()->word(),
            "casts" => self::faker()->words(2),
            "release_date" => self::faker()->date('d-m-Y'),
            "director" => sprintf("%s %s", self::faker()->name(), self::faker()->name()),
            "ratings" => [
                "imdb" => self::faker()->randomFloat(2, max: 10),
                "rotten_tomatoes" => self::faker()->randomFloat(2, max: 10),
            ],
        ];

        $client = self::createClient();
        $repository = self::getContainer()->get(MovieRepository::class);

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $createdMovie = $repository->findOneBy(['name' => $data['name']]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        $this->assertNull($createdMovie);
    }

    /**
     * @dataProvider invalidData
     */
    function test_unprocessable_entity(string $field, mixed $value)
    {
        // Arrange
        $data = [
            "name" => self::faker()->word(),
            "casts" => self::faker()->words(2),
            "release_date" => self::faker()->date('d-m-Y'),
            "director" => sprintf("%s %s", self::faker()->name(), self::faker()->name()),
            "ratings" => [
                "imdb" => self::faker()->randomFloat(2, max: 10),
                "rotten_tomatoes" => self::faker()->randomFloat(2, max: 10),
            ],
        ];

        $data[$field] = $value;

        $client = self::createClient();
        /** @var User $creator */
        $creator = UserFactory::createOne()->object();

        // Act
        $client->jsonRequest(
            'POST',
            self::ROUTE,
            $data,
            ['HTTP_Authorization' => "Bearer {$creator->getAccessToken()}"]
        );

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function invalidData()
    {
        # TODO: add validation for ratings' structure and release date format (d-m-Y)
        return [
            'missing name' => ['name', null],
            'empty casts' => ['casts', []],
            'missing release date' => ['release_date', null],
            'missing director' => ['director', null],
            'empty ratings' => ['ratings', []],
        ];
    }
}
