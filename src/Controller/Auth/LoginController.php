<?php

namespace App\Controller\Auth;

use App\Domain\User\Action\AuthenticateUserAction;
use App\Domain\User\DTO\AuthenticateUserDTO;
use App\Domain\User\Exception\AuthenticationFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LoginController
{
    public function __construct(
        private readonly AuthenticateUserAction $authenticateUserAction,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    /**
     * @Route("/api/auth/login")
     */
    public function __invoke(Request $request, AuthenticateUserDTO $dto): Response
    {
        try {
            $authenticateResultDTO = $this->authenticateUserAction->authenticate($dto);
        } catch (AuthenticationFailedException) {
            return new Response(status: Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(data: $this->normalizer->normalize($authenticateResultDTO), status: Response::HTTP_OK);
    }
}
