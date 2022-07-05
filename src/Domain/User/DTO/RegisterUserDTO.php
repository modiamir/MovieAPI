<?php

namespace App\Domain\User\DTO;

use App\DTO\DTOInterface;
use App\Validator\UniqueUserEmail;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterUserDTO implements DTOInterface
{
    public function __construct(
        #[NotBlank]
        #[Email]
        #[UniqueUserEmail]
        public ?string $email,
        #[NotBlank]
        #[Length(min: 8)]
        public ?string $password,
    ) {
    }
}
