<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
class UserProvider implements ProviderInterface
{

    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ItemProvider $itemProvider,
        #[Autowire(service: 'api_platform.doctrine.orm.state.collection_provider')]
        private CollectionProvider $collectionProvider,
    ) {}
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof GetCollection) {
            $data = $this->collectionProvider->provide($operation, $uriVariables, $context);

            foreach ($data as $item) {
                $hashedEmail = hash("SHA256", $item->getEmail());
                $item->setHashedEmail($hashedEmail);
            }

            return $data;
        }

        // Sinon c'est un item
        $data = $this->itemProvider->provide($operation, $uriVariables, $context);

        if ($data !== null) {
            $hashedEmail = hash("SHA256", $data->getEmail());
            $data->setHashedEmail($hashedEmail);
        }

        return $data;
    }

}
