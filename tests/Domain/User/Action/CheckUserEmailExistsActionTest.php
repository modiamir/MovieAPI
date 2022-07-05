<?php

namespace App\Tests\Domain\User\Action;

use App\Domain\User\Action\CheckUserEmailExistsAction;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Factory\UserFactory;
use App\Tests\IntegrationTestCase;
use App\Tests\UnitTestCase;
use Mockery;
use Mockery\MockInterface;

class CheckUserEmailExistsActionTest extends UnitTestCase
{
    function test_non_existing_email()
    {
        // Arrange
        $email = self::faker()->email();
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $action = new CheckUserEmailExistsAction($userRepository);

        // Expect
        $userRepository->shouldReceive('findOneByEmail')
            ->with($email)
            ->andReturn(null);

        // Act
        $result = $action->check($email);

        // Expect
        $this->assertFalse($result);
    }

    function test_duplicate_email()
    {
        // Arrange
        $email = self::faker()->email();
        $userRepository = Mockery::mock(UserRepositoryInterface::class);
        $action = new CheckUserEmailExistsAction($userRepository);

        // Expect
        $userRepository->shouldReceive('findOneByEmail')
            ->with($email)
            ->andReturn(new User());

        // Act
        $result = $action->check($email);

        // Expect
        $this->assertTrue($result);
    }
}
