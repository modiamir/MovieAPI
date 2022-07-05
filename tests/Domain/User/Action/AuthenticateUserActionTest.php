<?php

namespace App\Tests\Domain\User\Action;

use App\Domain\User\Action\AuthenticateUserAction;
use App\Domain\User\DTO\AuthenticateUserDTO;
use App\Domain\User\DTO\AuthenticationResultDTO;
use App\Domain\User\Exception\AuthenticationFailedException;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Service\AccessTokenService;
use App\Domain\User\Service\UniqueTokenGeneratorInterface;
use App\Domain\User\Service\UserPasswordService;
use App\Domain\User\Service\UserPersistenceServiceInterface;
use App\Factory\UserFactory;
use App\Tests\UnitTest;
use Hamcrest\Core\IsEqual;
use Mockery;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticateUserActionTest extends UnitTest
{
    function test_authenticate_with_correct_credentials()
    {
        // Arrange
        $email = self::faker()->email();
        $password = self::faker()->password();
        $user = UserFactory::new([
            'email' => $email,
            'password' => $password,
        ])->withoutPersisting()->create();
        $expectedAccessToken = self::faker()->randomAscii();

        $userPersistenceService = Mockery::spy(UserPersistenceServiceInterface::class);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $uniqueTokenGenerator = Mockery::mock(UniqueTokenGeneratorInterface::class);
        $accessTokenService = new AccessTokenService($uniqueTokenGenerator);

        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordService = new UserPasswordService($userPasswordHasher);

        $dto = new AuthenticateUserDTO($email, $password);

        $action = new AuthenticateUserAction(
            $userRepository,
            $userPersistenceService,
            $userPasswordService,
            $accessTokenService
        );

        // Expect
        $userRepository->shouldReceive('findOneByEmail')
            ->with($user->getEmail())
            ->andReturn($user->object());

        $uniqueTokenGenerator->shouldReceive('generate')->andReturn($expectedAccessToken);
        $userPasswordHasher->shouldReceive('isPasswordValid')
            ->with($user->object(), $user->getPassword())->andReturn(true);

        // Act
        $result = $action->authenticate($dto);

        // Assert
        $this->assertEquals(new AuthenticationResultDTO($expectedAccessToken), $result);
        $userPersistenceService->shouldHaveReceived('save')->once()->with(IsEqual::equalTo($user->object()));
        $this->assertEquals($expectedAccessToken, $user->getAccessToken());
    }

    function test_authenticate_with_wrong_password()
    {
        // Arrange
        $email = self::faker()->email();
        $password = self::faker()->password();
        $user = UserFactory::new([
            'email' => $email,
            'password' => $password,
        ])->withoutPersisting()->create();

        $userPersistenceService = Mockery::spy(UserPersistenceServiceInterface::class);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $uniqueTokenGenerator = Mockery::mock(UniqueTokenGeneratorInterface::class);
        $accessTokenService = new AccessTokenService($uniqueTokenGenerator);

        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordService = new UserPasswordService($userPasswordHasher);

        $dto = new AuthenticateUserDTO($email, $password);

        $action = new AuthenticateUserAction(
            $userRepository,
            $userPersistenceService,
            $userPasswordService,
            $accessTokenService
        );

        // Expect
        $userRepository->shouldReceive('findOneByEmail')
            ->with($user->getEmail())
            ->andReturn($user->object());

        $userPasswordHasher->shouldReceive('isPasswordValid')
            ->with($user->object(), $user->getPassword())->andReturn(false);

        $this->expectException(AuthenticationFailedException::class);

        // Act
        $action->authenticate($dto);

        // Assert
        $userPersistenceService->shouldHaveReceived('save')->never();
        $this->assertNull($user->getAccessToken());
    }

    function test_authenticate_with_invalid_email()
    {
        // Arrange
        $email = self::faker()->email();
        $password = self::faker()->password();

        $userPersistenceService = Mockery::spy(UserPersistenceServiceInterface::class);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);

        $uniqueTokenGenerator = Mockery::mock(UniqueTokenGeneratorInterface::class);
        $accessTokenService = new AccessTokenService($uniqueTokenGenerator);

        $userPasswordHasher = Mockery::mock(UserPasswordHasherInterface::class);
        $userPasswordService = new UserPasswordService($userPasswordHasher);

        $dto = new AuthenticateUserDTO($email, $password);

        $action = new AuthenticateUserAction(
            $userRepository,
            $userPersistenceService,
            $userPasswordService,
            $accessTokenService
        );

        // Expect
        $userRepository->shouldReceive('findOneByEmail')
            ->with($email)
            ->andReturn(null);

        $this->expectException(AuthenticationFailedException::class);

        // Act
        $action->authenticate($dto);

        // Assert
        $userPersistenceService->shouldHaveReceived('save')->never();
    }
}
