<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UnvalidatedGameProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $persistProvider)
    {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Retrieve the state from somewhere
        $data = $this->persistProvider->provide($operation, $uriVariables, $context);   
        $array = array();
        foreach ($data as $game) {
            if ($date->isApprouved()) {
                array_push($array, $game);
            }
        }
        return $array;
    }
}
