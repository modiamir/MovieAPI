<?php

namespace App\Tests\Service\User;

use App\Domain\User\Entity\User;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Service\User\UserPersistenceService;
use App\Tests\IntegrationTestCase;

class UserPersistenceServiceTest extends IntegrationTestCase
{
    function test_saving_a_new_user()
    {
        // Arrange
        /** @var User $user */
        $user = UserFactory::new()->withoutPersisting()->create()->object();

        /** @var UserPersistenceService $service */
        $service = self::getContainer()->get(UserPersistenceService::class);

        /** @var UserRepository $repository */
        $repository = self::getContainer()->get(UserRepository::class);

        // Act
        $service->save($user);

        // Assert
        $this->assertNotNull($repository->findOneBy(['email' => $user->getEmail()]));
    }
}
