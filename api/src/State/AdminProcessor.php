<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class AdminProcessor implements ProcessorInterface
{
    public function __construct(#[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
                                private ProcessorInterface $persistProcessor)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $roles = $data->getRoles();
        unset($roles[array_search('ROLE_USER', $roles)]); // remove 'ROLE_USER' from $roles
        if(!in_array('ROLE_ADMIN', $roles)){
            $roles[] = "ROLE_ADMIN";
        }
        $data->setRoles($roles);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
