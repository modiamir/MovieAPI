<?php

namespace App\Tests\Service\User;

use App\Service\User\UniqueTokenGenerator;
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
