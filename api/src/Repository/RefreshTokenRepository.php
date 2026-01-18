<?php
#src/Repository
namespace App\Repository;

use App\Entity\RefreshToken;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RefreshToken>
 */
class RefreshTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefreshToken::class);
    }

    //Méthode pour supprimer les tokens invalides
    public function removeExpiredTokens() : void {
        $queryBuilder = $this->createQueryBuilder('rt')
            ->delete()
            ->where("rt.expiresAt <= :date")
            ->setParameter('date', new DateTime());
        $query = $queryBuilder->getQuery();
        $query->execute();
    }
}

