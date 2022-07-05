<?php

namespace App\Controller\Movie;

use App\Domain\Movie\Action\GetMovieListAction;
use App\Domain\User\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GetMovieListController
{
    public function __construct(
        private readonly NormalizerInterface $normalizer,
        private readonly GetMovieListAction $getMovieListAction,
        private readonly Security $security
    ) {
    }

    #[Route("/api/v1/movies", methods: ["GET"])]
    public function __invoke(): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $movies = $this->getMovieListAction->get($user);

        return new JsonResponse($this->normalizer->normalize($movies, 'json', ['groups' => ['movie.list']]));
    }
}
