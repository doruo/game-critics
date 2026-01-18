<?php
namespace App\Service\RefreshToken\Manager;

use App\Repository\RefreshTokenRepository;
use App\Service\RefreshToken\Hasher\RefreshTokenHasherInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: 'gesdinet.jwtrefreshtoken.refresh_token_manager')]
class RefreshTokenManagerDecorator implements RefreshTokenManagerInterface
{
    public function __construct(
        //On obtient le service de base que l'on décore
        #[AutowireDecorated] private RefreshTokenManagerInterface $inner,
        private RefreshTokenRepository $refreshTokenRepository,
        private RefreshTokenHasherInterface $hasher,
    )
    {}

    //On modifie le comportement de "get"
    public function get($plainTextToken)
    {
        return $this->refreshTokenRepository->findOneBy(['hashedRefreshToken' => $this->hasher->hashToken($plainTextToken)]);
    }

    //Pour les autres opérations, on délègue simplement au service de base décoré
    public function save(RefreshTokenInterface $refreshToken, $andFlush = true) {$this->inner->save($refreshToken, $andFlush);}
    public function create(){return $this->inner->create();}
    public function getLastFromUsername($username) {return $this->inner->getLastFromUsername($username);}
    public function delete(RefreshTokenInterface $refreshToken) {$this->inner->delete($refreshToken);}
    public function revokeAllInvalid($datetime = null) {return $this->inner->revokeAllInvalid($datetime);}
    public function getClass() {return $this->inner->getClass();}
}