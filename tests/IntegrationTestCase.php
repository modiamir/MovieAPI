<?php

namespace App\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class IntegrationTestCase extends KernelTestCase
{
    use MockeryPHPUnitIntegration;
    use FakerTrait;
    use Factories;
}
