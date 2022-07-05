<?php

namespace App\Controller\Auth;

use App\Domain\User\Action\RegisterUserAction;
use App\Domain\User\DTO\RegisterUserDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController
{
    public function __construct(private readonly RegisterUserAction $registerUserAction)
    {
    }

    /**
     * @Route("/api/auth/register", methods={"POST"})
     */
    public function __invoke(Request $request, RegisterUserDTO $dto): Response
    {
        $this->registerUserAction->register($dto);

        return new Response(status: Response::HTTP_CREATED);
    }
}
