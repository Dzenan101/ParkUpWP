<?php

namespace App\services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    // In real app, move this to env/config
    private const SECRET = 'CHANGE_ME_SUPER_SECRET_KEY';
    private const ISSUER = 'parkup_api';
    private const TOKEN_TTL = 3600 * 24; // 24h

    public static function generateToken(array $user): string
    {
        $now = time();

        $payload = [
            'iss'  => self::ISSUER,
            'iat'  => $now,
            'exp'  => $now + self::TOKEN_TTL,
            'sub'  => $user['id'],
            'user' => [
                'id'    => $user['id'],
                'email' => $user['email'],
                'role'  => $user['role'] ?? 'user',
                'full_name' => $user['full_name'] ?? '',
            ],
        ];

        return JWT::encode($payload, self::SECRET, 'HS256');
    }

    public static function verifyToken(string $token): array
    {
        $decoded = JWT::decode($token, new Key(self::SECRET, 'HS256'));

        // turn into array and return just the "user" part
        $data = (array) $decoded;

        return (array) ($data['user'] ?? []);
    }
}
