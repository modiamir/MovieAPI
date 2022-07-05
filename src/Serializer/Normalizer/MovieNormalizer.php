<?php

namespace App\Serializer\Normalizer;

use App\Domain\Movie\Entity\Cast;
use App\Domain\Movie\Entity\Movie;
use App\Domain\Movie\Entity\Rating;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MovieNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    public function __construct(private readonly ObjectNormalizer $normalizer)
    {
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        /** @var Movie $object */

        $context[DateTimeNormalizer::FORMAT_KEY] = 'd-m-Y';

        $data = $this->normalizer->normalize($object, $format, $context);

        if (in_array('movie.details', $context['groups'])) {
            $data['casts'] = $object->getCasts()->map(fn(Cast $cast) => $cast->getName())->toArray();
            $data['ratings'] = array_reduce($object->getRatings()->toArray(), function ($ratings, Rating $rating) {
                $ratings[$rating->getPlatformName()] = $rating->getRate();

                return $ratings;
            }, []);
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof \App\Domain\Movie\Entity\Movie;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
