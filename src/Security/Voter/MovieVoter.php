<?php

namespace App\Security\Voter;

use App\Domain\Movie\Entity\Movie;
use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MovieVoter extends Voter
{
    public const VIEW = 'MOVIE_VIEW';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::VIEW]) && $subject instanceof Movie;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Movie $subject */
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::VIEW => $user->getId() === $subject->getOwner()->getId(),
            default => false,
        };
    }
}
