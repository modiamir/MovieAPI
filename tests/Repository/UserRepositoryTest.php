<?php

namespace App\Tests\Repository;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Tests\IntegrationTestCase;

class UserRepositoryTest extends IntegrationTestCase
{
    function test_fetching_an_existing_user()
    {
        // Arrange
        $user = UserFactory::createOne();

        /** @var UserRepository $repository */
        $repository = self::getContainer()->get(UserRepository::class);

        // Act
        $result = $repository->findOneByEmail($user->getEmail());

        // Assert
        $this->assertNotNull($result);
    }

    function test_fetching_a_non_existing_user()
    {
        // Arrange
        /** @var UserRepository $repository */
        $repository = self::getContainer()->get(UserRepository::class);

        // Act
        $result = $repository->findOneByEmail(self::faker()->email());

        // Assert
        $this->assertNull($result);
    }
}
