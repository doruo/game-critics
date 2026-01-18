<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProvider implements ProviderInterface
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher,
                                #[Autowire(service: 'api_platform.doctrine.orm.state.item_provider')]
                                private ProviderInterface $persistProvider)
    {
    }
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $data = $this->persistProvider->provide($operation, $uriVariables, $context);

        if($data!==null){
            $hashedEmail = $this->passwordHasher->hashPassword($data, $data->getEmail());
            $data->setHashedEmail($hashedEmail);
        }

        return $data;
    }
}
