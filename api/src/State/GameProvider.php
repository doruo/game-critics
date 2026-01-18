<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class GameProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ItemProvider $itemProvider,
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private CollectionProvider $collectionProvider,)
    {}
    
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {
            $data = $this->collectionProvider->provide($operation, $uriVariables, $context);
            $data = is_iterable($data) ? iterator_to_array($data) : $data;
            $data = array_filter($data, function ($item) {return $item->isApproved()===true;}); // isApproved() => ?bool
            $data = array_values($data);

            foreach ($data as $item) {
                $item->setAvgNote($this->avgCritic($item));
            }

            return $data;
        }

        $data = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($data !== null) {
            $data->setAvgNote($this->avgCritic($data));
        }

        return $data;
    }

    private function avgCritic($game) : ?float{
        $nbCritics = count($game->getCritics());
        if($nbCritics===0)return null;
        $avg = 0;
        foreach ($game->getCritics() as $critic) {
            $avg += $critic->getNote();
        }
        return (float)($avg/$nbCritics);
    }
}
