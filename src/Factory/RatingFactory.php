<?php

namespace App\Factory;

use App\Domain\Movie\Entity\Rating;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Rating>
 *
 * @method static Rating|Proxy createOne(array $attributes = [])
 * @method static Rating[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Rating|Proxy find(object|array|mixed $criteria)
 * @method static Rating|Proxy findOrCreate(array $attributes)
 * @method static Rating|Proxy first(string $sortedField = 'id')
 * @method static Rating|Proxy last(string $sortedField = 'id')
 * @method static Rating|Proxy random(array $attributes = [])
 * @method static Rating|Proxy randomOrCreate(array $attributes = [])
 * @method static Rating[]|Proxy[] all()
 * @method static Rating[]|Proxy[] findBy(array $attributes)
 * @method static Rating[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Rating[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Rating|Proxy create(array|callable $attributes = [])
 */
final class RatingFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'platformName' => self::faker()->word(),
            'rate' => self::faker()->randomFloat(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Rating $rating): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Rating::class;
    }
}
