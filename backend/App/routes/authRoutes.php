<?php

use App\services\UserService;
use App\services\AuthService;

// POST /auth/register
Flight::route('POST /auth/register', function () {
    $data = Flight::request()->data->getData();
    $userService = new UserService();

    try {
        $user = $userService->register($data);
        $token = AuthService::generateToken($user);

        Flight::json([
            'user'  => $user,
            'token' => $token,
        ], 201);
    } catch (\Exception $e) {
        Flight::json(['error' => $e->getMessage()], 400);
    }
});

// POST /auth/login
Flight::route('POST /auth/login', function () {
    $data = Flight::request()->data->getData();
    $userService = new UserService();

    if (empty($data['email']) || empty($data['password'])) {
        Flight::json(['error' => 'email and password required'], 400);
        return;
    }

    try {
        $user = $userService->login($data['email'], $data['password']);
        $token = AuthService::generateToken($user);

        Flight::json([
            'user'  => $user,
            'token' => $token,
        ]);
    } catch (\Exception $e) {
        Flight::json(['error' => $e->getMessage()], 401);
    }
});
