<?php

namespace App\Service\RefreshToken\Hasher;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class RefreshTokenHasher implements RefreshTokenHasherInterface
{

    public function __construct(#[Autowire(env: 'APP_SECRET')] private string $secret)
    {}

    public function hashToken(string $plainTextToken): string
    {
        return hash_hmac('sha256', $plainTextToken, $this->secret);
    }
}