<?php

namespace App\Controller\Movie;

use App\Domain\Movie\Action\GetSingleMovieAction;
use App\Security\Voter\MovieVoter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GetSingleMovieController
{
    public function __construct(
        private readonly GetSingleMovieAction $getSingleMovieAction,
        private readonly NormalizerInterface $normalizer,
        private readonly AuthorizationCheckerInterface $authorizationChecker
    ) {
    }

    #[Route("/api/v1/movies/{movieId}", methods: ["GET"])]
    public function __invoke(int $movieId): Response
    {
        $movie = $this->getSingleMovieAction->get($movieId);

        if (is_null($movie)) {
            return new Response(status: Response::HTTP_NOT_FOUND);
        }

        if (!$this->authorizationChecker->isGranted(MovieVoter::VIEW, $movie)) {
            return new Response(status: Response::HTTP_FORBIDDEN);
        }

        return new JsonResponse($this->normalizer->normalize($movie, 'json', ['groups' => ['movie.details']]));
    }
}
