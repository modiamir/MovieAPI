<?php

namespace App\Tests\Infrastructure\User\Service;

use App\Infrastructure\User\Service\UniqueTokenGenerator;
use App\Tests\UnitTestCase;

class UniqueTokenGeneratorTest extends UnitTestCase
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
