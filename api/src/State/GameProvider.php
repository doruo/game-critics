<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class GameProvider implements ProviderInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
        private ProviderInterface $persistProvider)
    {}
    
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $data = $this->persistProvider->provide($operation, $uriVariables, $context);
        $avg = 0;
        foreach ($data->getCritics() as $crtitic) {
            $avg += $crtitic->getNote();
        }
        $data->setAvgNote($avg);
        return $data;
    }
}
