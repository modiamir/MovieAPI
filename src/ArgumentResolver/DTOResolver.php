<?php

namespace App\ArgumentResolver;

use App\DTO\DTOInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DTOResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return isset(class_implements($argument->getType())[DTOInterface::class]);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $dto = $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');
        $violationList = $this->validator->validate($dto);
        if ($violationList->count() > 0) {
            throw new ValidationFailedException($dto, $violationList);
        }

        yield $dto;
    }
}
