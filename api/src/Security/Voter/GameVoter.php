<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class GameVoter extends Voter
{
    public const PUBLIC_OR_ADMIN = 'GAME_IS_PUBLIC_OR_ADMIN';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::PUBLIC_OR_ADMIN])
            && $subject instanceof \App\Entity\Game;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        switch ($attribute) {
            case self::PUBLIC_OR_ADMIN:
                return $subject->isApproved() || ($user!== null && (in_array("ROLE_ADMIN",$user->getRoles())));
        }

        return false;
    }
}
