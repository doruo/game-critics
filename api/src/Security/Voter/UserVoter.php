<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
final class UserVoter extends Voter
{


    // everyone can access themself, admin can always access
    public const SELF_CONNECTED_OR_ADMIN = 'USER_SELF_CONNECTED_OR_ADMIN';

    // everyone can access themself but nobody else can, even admins
    public const SELF_CONNECTED_ONLY = 'USER_SELF_CONNECTED_ONLY';

    // everyone can access themself, admin can access non admin
    public const SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN = 'USER_SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN';

    // only admin can access but not for an admin (except themself)
    public const ADMIN_EXCEPT_ADMIN = 'USER_ADMIN_EXCEPT_ADMIN';




    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::SELF_CONNECTED_OR_ADMIN,self::SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN,
                self::ADMIN_EXCEPT_ADMIN,self::SELF_CONNECTED_ONLY])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if ($user == null) {
            return false;
        }

        switch ($attribute) {
            case self::SELF_CONNECTED_OR_ADMIN:
                return $subject->getId()  == $user->getId() || in_array("ROLE_ADMIN",$user->getRoles());

            case self::SELF_CONNECTED_ONLY:
                return $subject->getId()  == $user->getId();

            case self::SELF_CONNECTED_OR_ADMIN_EXCEPT_ADMIN:
                return $subject->getId()  == $user->getId() ||  (in_array("ROLE_ADMIN",$user->getRoles())
                        && !in_array("ROLE_ADMIN",$subject->getRoles())) ;

            case self::ADMIN_EXCEPT_ADMIN:
                return $subject->getId()  == $user->getId() && in_array("ROLE_ADMIN",$user->getRoles()) ||
                    (in_array("ROLE_ADMIN",$user->getRoles()) && !in_array("ROLE_ADMIN",$subject->getRoles())) ;
        }

        return false;
    }
}
