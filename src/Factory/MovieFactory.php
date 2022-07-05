<?php

namespace App\Factory;

use App\Domain\Movie\Entity\Movie;
use App\Repository\MovieRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Movie>
 *
 * @method static Movie|Proxy createOne(array $attributes = [])
 * @method static Movie[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Movie|Proxy find(object|array|mixed $criteria)
 * @method static Movie|Proxy findOrCreate(array $attributes)
 * @method static Movie|Proxy first(string $sortedField = 'id')
 * @method static Movie|Proxy last(string $sortedField = 'id')
 * @method static Movie|Proxy random(array $attributes = [])
 * @method static Movie|Proxy randomOrCreate(array $attributes = [])
 * @method static Movie[]|Proxy[] all()
 * @method static Movie[]|Proxy[] findBy(array $attributes)
 * @method static Movie[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Movie[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MovieRepository|RepositoryProxy repository()
 * @method Movie|Proxy create(array|callable $attributes = [])
 */
final class MovieFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->word(),
            'releaseDate' => self::faker()->datetime(),
            'director' => self::faker()->word(),
            'owner' => UserFactory::createOne(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Movie $movie): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Movie::class;
    }
}
