<?php

namespace App\Tests\Domain\User\Action;

use App\Domain\User\Action\RegisterUserAction;
use App\Domain\User\DTO\RegisterUserDTO;
use App\Domain\User\Entity\User;
use App\Domain\User\Exception\UserEmailDuplicateException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\UserCreator;
use App\Domain\User\Service\UserPasswordService;
use App\Domain\User\Service\UserPersistenceServiceInterface;
use App\Factory\UserFactory;
use App\Tests\IntegrationTestCase;
use App\Tests\UnitTestCase;
use Hamcrest\Core\IsEqual;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserActionTest extends UnitTestCase
{
    function test_register_successfully()
    {
        // Arrange
        $registerUserDTO = new RegisterUserDTO(email: self::faker()->email(), password: self::faker()->email());
        $userPersistenceService = Mockery::spy(UserPersistenceServiceInterface::class);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $action = new RegisterUserAction($userPersistenceService, $userRepository, $this->getUserCreator());

        // Expect
        $expectedUser = UserFactory::new([
            'email' => $registerUserDTO->email,
            'roles' => ['ROLE_USER'],
            'password' => "plain:$registerUserDTO->password",
            'accessToken' => null
        ])->withoutPersisting()->create()->object();
        $userRepository->shouldReceive('findOneByEmail')->with($registerUserDTO->email)->andReturn(null);

        // Act
        $result = $action->register($registerUserDTO);

        // Assert
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($expectedUser, $result);
        $userPersistenceService->shouldHaveReceived('save')
            ->with(IsEqual::equalTo($expectedUser))
            ->once();
    }

    function test_register_failed_due_to_duplicate_email()
    {
        // Arrange
        $registerUserDTO = new RegisterUserDTO(email: self::faker()->email(), password: self::faker()->email());
        $userPersistenceService = Mockery::spy(UserPersistenceServiceInterface::class);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $action = new RegisterUserAction($userPersistenceService, $userRepository, $this->getUserCreator());

        //Expect
        $userRepository->shouldReceive('findOneByEmail')
            ->with($registerUserDTO->email)
            ->andReturn(UserFactory::new()->withoutPersisting()->create()->object());

        $this->expectException(UserEmailDuplicateException::class);

        // Act
        $action->register($registerUserDTO);

        // Assert
        $userPersistenceService->shouldHaveReceived('save')
            ->never();
    }

    private function getUserCreator(): UserCreator
    {
        $passwordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $passwordHasher->shouldReceive('hashPassword')->andReturnUsing(fn ($user, $password) => "plain:$password");
        $userPasswordService = new UserPasswordService($passwordHasher);

        return new UserCreator($userPasswordService);
    }
}
