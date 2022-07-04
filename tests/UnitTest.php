<?php

namespace App\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Zenstruck\Foundry\Test\Factories;

class UnitTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    use FakerTrait;
    use Factories;
}
