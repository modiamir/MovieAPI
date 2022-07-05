<?php

namespace App\Tests\Controller\Auth;

use App\Factory\UserFactory;
use App\Tests\ApplicationTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginControllerTest extends ApplicationTestCase
{
    private const ROUTE = '/api/auth/login';

    function test_successful()
    {
        // Arrange
        $rawPassword = self::faker()->password(8);
        $client = self::createClient();
        $user = UserFactory::createOne();
        $hashedPassword = self::getContainer()
            ->get(UserPasswordHasherInterface::class)
            ->hashPassword($user->object(), $rawPassword);
        $user->setPassword($hashedPassword);
        self::getContainer()->get(EntityManagerInterface::class)->flush();

        $data = [
            'email' => $user->getEmail(),
            'password' => $rawPassword,
        ];

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseFormatSame('json');
        $this->assertEquals(json_encode(['token' => $user->getAccessToken()]), $client->getResponse()->getContent());
    }

    function test_unauthorized_due_to_wrong_password()
    {
        // Arrange
        $rawPassword = self::faker()->password(8);
        $client = self::createClient();
        $user = UserFactory::createOne();
        $hashedPassword = self::getContainer()
            ->get(UserPasswordHasherInterface::class)
            ->hashPassword($user->object(), $rawPassword);
        $user->setPassword($hashedPassword);
        self::getContainer()->get(EntityManagerInterface::class)->flush();

        $data = [
            'email' => $user->getEmail(),
            'password' => 'wrongpassword',
        ];

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    function test_unauthorized_due_to_wrong_email()
    {
        // Arrange
        $client = self::createClient();
        $data = [
            'email' => self::faker()->email(),
            'password' => self::faker()->password(8),
        ];

        // Act
        $client->jsonRequest('POST', self::ROUTE, $data);

        // Assert
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
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
        ];
    }
}
