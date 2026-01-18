<?php
namespace App\Service\RefreshToken\Hasher;

interface RefreshTokenHasherInterface
{
    public function hashToken(string $plainTextToken) : string;
}