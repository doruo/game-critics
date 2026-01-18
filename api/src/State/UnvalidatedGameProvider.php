<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UnvalidatedGameProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private CollectionProvider $collectionProvider,)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $data = $this->collectionProvider->provide($operation, $uriVariables, $context);
        $data = is_iterable($data) ? iterator_to_array($data) : $data;
        $data = array_filter($data, function ($item) {return $item->isApproved()!==true;}); // isApproved() => ?bool
        $data = array_values($data);

        return $data;
    }
}
