<?php

namespace App\Tests;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    private static ?Generator $faker = null;

    public static function faker(): Generator
    {
        if (is_null(self::$faker)) {
            self::$faker = Factory::create();
        }

        return self::$faker;
    }
}
