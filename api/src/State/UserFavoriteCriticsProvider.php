<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Entity\Critic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UserFavoriteCriticsProvider implements ProviderInterface
{
    public function __construct(private EntityManagerInterface $entityManager
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $data = $this->entityManager->getRepository(User::class)->find($uriVariables['id']);
        $critics = [];


        if($data!==null){
            foreach ($data->getFavoritesGames() as $game) {
                foreach ($game->getCritics() as $critic) {
                    $critics[] = $critic;
                }
            }
        }

        return $critics;

    }
}

