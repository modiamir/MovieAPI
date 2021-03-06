<?php

namespace App\Factory;

use App\Domain\Movie\Entity\Cast;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Cast>
 *
 * @method static Cast|Proxy createOne(array $attributes = [])
 * @method static Cast[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Cast|Proxy find(object|array|mixed $criteria)
 * @method static Cast|Proxy findOrCreate(array $attributes)
 * @method static Cast|Proxy first(string $sortedField = 'id')
 * @method static Cast|Proxy last(string $sortedField = 'id')
 * @method static Cast|Proxy random(array $attributes = [])
 * @method static Cast|Proxy randomOrCreate(array $attributes = [])
 * @method static Cast[]|Proxy[] all()
 * @method static Cast[]|Proxy[] findBy(array $attributes)
 * @method static Cast[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Cast[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Cast|Proxy create(array|callable $attributes = [])
 */
final class CastFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->word(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Cast $cast): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Cast::class;
    }
}
