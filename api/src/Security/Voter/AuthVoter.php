<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthVoter extends Voter
{
    public const CONNECTED = 'AUTH_CONNECTED';
    public const ADMIN = 'AUTH_ADMIN';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CONNECTED, self::ADMIN]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if ($user == null) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::CONNECTED:
                return true; // we already verified that $user != null

            case self::ADMIN:
                return in_array("ROLE_ADMIN",$user->getRoles());
        }

        return false;
    }
}
