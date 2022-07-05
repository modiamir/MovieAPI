<?php

namespace App\Tests\Controller\Auth;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Tests\ApplicationTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserControllerTest extends ApplicationTestCase
{
    private const ROUTE = '/api/auth/register';

    function test_successful()
    {
        // Arrange
        $data = [
            'email' => self::faker()->email(),
            'password' => self::faker()->password(8),
        ];

        $client = self::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $expectedUser = $userRepository->findOneBy(['email' => $data['email']]);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertNotNull($expectedUser);
    }

    function test_error_on_duplicate_user()
    {
        // Arrange
        $data = [
            'email' => self::faker()->email(),
            'password' => self::faker()->password(8),
        ];

        $client = self::createClient();

        UserFactory::createOne(['email' => $data['email']]);

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @dataProvider invalidData
     */
    function test_with_validation_errors(string $field, mixed $value)
    {
        // Arrange
        $data = [
            'email' => self::faker()->email(),
            'password' => self::faker()->password(8),
        ];

        $data[$field] = $value;

        $client = self::createClient();

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function invalidData(): array
    {
        return [
            'missing email' => ['email', null],
            'invalid email format' => ['email', 'wrong email'],
            'missing password' => ['password', null],
            'short password' => ['password', 'short']
        ];
    }
}
