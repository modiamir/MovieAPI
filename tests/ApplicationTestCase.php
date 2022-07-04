<?php

namespace App\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ApplicationTestCase extends WebTestCase
{
    use MockeryPHPUnitIntegration;
    use FakerTrait;
    use Factories;
}
