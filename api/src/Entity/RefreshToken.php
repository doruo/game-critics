<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[ORM\Table(name: 'refresh_tokens')]
#[UniqueEntity('hashedRefreshToken')] //Permet de vérifier que le token est unique (du côté application)
class RefreshToken extends BaseRefreshToken
{
    //Le "unique: true" permet de rajouter une contrainte d'unicité sur cet attribut
    #[ORM\Column(length: 255, unique: true)]
    #[ApiProperty(readable: false)]
    private ?string $hashedRefreshToken = null;

    public function getHashedRefreshToken(): ?string
    {
        return $this->hashedRefreshToken;
    }

    public function setHashedRefreshToken(string $hashedRefreshToken): static
    {
        $this->hashedRefreshToken = $hashedRefreshToken;

        return $this;
    }
}