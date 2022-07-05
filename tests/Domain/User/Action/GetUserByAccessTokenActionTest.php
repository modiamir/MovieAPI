<?php

namespace App\Tests\Domain\User\Action;

use App\Domain\User\Action\CheckUserEmailExistsAction;
use App\Domain\User\Action\GetUserByAccessTokenAction;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Tests\UnitTestCase;
use Mockery;

class GetUserByAccessTokenActionTest extends UnitTestCase
{
    function test_does_not_get_user()
    {
        // Arrange
        $accessToken = self::faker()->password(50);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $action = new GetUserByAccessTokenAction($userRepository);

        // Expect
        $userRepository->shouldReceive('findOneByAccessToken')
            ->with($accessToken)
            ->andReturn(null);

        // Act
        $result = $action->get($accessToken);

        // Expect
        $this->assertNull($result);
    }

    function test_get_user_successfully()
    {
        // Arrange
        $accessToken = self::faker()->password(50);
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $action = new GetUserByAccessTokenAction($userRepository);

        // Expect
        $userRepository->shouldReceive('findOneByAccessToken')
            ->with($accessToken)
            ->andReturn(new User());

        // Act
        $result = $action->get($accessToken);

        // Expect
        $this->assertInstanceOf(User::class, $result);
    }
}
