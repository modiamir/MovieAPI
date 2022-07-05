<?php

namespace App\Tests\Service\User;

use App\Service\User\UniqueTokenGenerator;
use App\Tests\UnitTest;

class UniqueTokenGeneratorTest extends UnitTest
{
    function test_generate()
    {
        // Arrange
        $service = new UniqueTokenGenerator();

        // Act
        $result = $service->generate();

        // Assert
        $this->assertNotNull($result);
    }
}
