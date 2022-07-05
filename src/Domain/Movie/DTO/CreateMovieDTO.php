<?php

namespace App\Domain\Movie\DTO;

use App\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateMovieDTO implements DTOInterface
{
    public function __construct(
        #[NotBlank]
        public ?string $name,
        #[NotBlank]
        public ?string $releaseDate,
        #[NotBlank]
        public ?string $director,
        #[Type(type: 'array')]
        #[NotBlank]
        public ?array $casts = [],
        #[Type(type: 'array')]
        #[NotBlank]
        public ?array $ratings = [],
    ) {
    }
}
