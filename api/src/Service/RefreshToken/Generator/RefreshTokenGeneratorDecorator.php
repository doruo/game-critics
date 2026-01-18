<?php

namespace App\Service\RefreshToken\Generator;

use App\Entity\RefreshToken;
use App\Service\RefreshToken\Hasher\RefreshTokenHasherInterface;
use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\User\UserInterface;

#[AsDecorator(decorates: 'gesdinet.jwtrefreshtoken.refresh_token_generator')]
class RefreshTokenGeneratorDecorator implements RefreshTokenGeneratorInterface
{
    public function __construct(
        #[AutowireDecorated] private RefreshTokenGeneratorInterface $inner,
        private RefreshTokenHasherInterface $hasher,
        //Notre service décoré précédemment sera injecté !
        private RefreshTokenManagerInterface $refreshTokenManager
    )
    {}
    public function createForUserWithTtl(UserInterface $user, int $ttl): RefreshTokenInterface
    {
        /**
         * @var RefreshToken $token
         */
        $token = $this->inner->createForUserWithTtl($user, $ttl);
        $token->setHashedRefreshToken($this->hasher->hashToken($token->getRefreshToken()));
        return $token;
    }
}