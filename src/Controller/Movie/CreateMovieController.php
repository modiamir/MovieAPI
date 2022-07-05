<?php

namespace App\Controller\Movie;

use App\Domain\Movie\Action\CreateMovieAction;
use App\Domain\Movie\DTO\CreateMovieDTO;
use App\Domain\Movie\Entity\Movie;
use App\Domain\User\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CreateMovieController
{
    public function __construct(
        private readonly CreateMovieAction $createMovieAction,
        private readonly Security $security
    ) {
    }

    #[Route("/api/v1/movies", methods: ["POST"])]
    public function __invoke(CreateMovieDTO $dto)
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->createMovieAction->create($dto, $user);

        return new Response(status: Response::HTTP_CREATED);
    }
}
