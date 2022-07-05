<?php

namespace App\Domain\User\DTO;

use App\DTO\DTOInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class AuthenticateUserDTO implements DTOInterface
{
    public function __construct(
        #[NotBlank]
        #[Email]
        public ?string $email,
        #[NotBlank]
        public ?string $password
    ) {
    }
}
