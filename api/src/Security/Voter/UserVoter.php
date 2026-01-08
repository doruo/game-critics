<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
final class UserVoter extends Voter
{
    public const CONNECTED = 'USER_CONNECTED';

    // everyone can access themself, admin can always access
    public const SELF_CONNECTED_OR_ADMIN = 'USER_SELF_CONNECTED_OR_ADMIN';

    // everyone can access themself, admin can access non admin
    public const SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN = 'USER_SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN';
    public const ADMIN = 'USER_ADMIN';


    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::SELF_CONNECTED_OR_ADMIN, self::CONNECTED, self::ADMIN,self::SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if ($user == null) {
            return false;
        }

        switch ($attribute) {
            case self::CONNECTED:
                return true; // we already verified that $user != null

            case self::SELF_CONNECTED_OR_ADMIN:
                return $subject->getId()  == $user->getId() || in_array("ROLE_ADMIN",$user->getRoles());

            case self::ADMIN:
                return in_array("ROLE_ADMIN",$user->getRoles());

            case self::SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN:
                return $subject->getId()  == $user->getId() ||  (in_array("ROLE_ADMIN",$user->getRoles())
                        && !in_array("ROLE_ADMIN",$subject->getRoles())) ;
        }

        return false;
    }
}
