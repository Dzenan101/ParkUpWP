<?php

use App\services\UserService;

// GET /users - list all (ADMIN ONLY)
Flight::route('GET /users', function () {
    Flight::requireRole('admin');

    $service = new UserService();
    $users   = $service->getAllUsers();

    // hide password hashes
    foreach ($users as &$u) {
        unset($u['password_hash']);
    }

    Flight::json($users);
});

// GET /users/@id - admin or the user himself
Flight::route('GET /users/@id', function ($id) {
    $current = Flight::get('user');

    if ($current['role'] !== 'admin' && (string)$current['id'] !== (string)$id) {
        Flight::haltJson(403, 'Forbidden: cannot view other users');
    }

    $service = new UserService();
    $user    = $service->getUserById($id);

    if (!$user) {
        Flight::json(['error' => 'User not found'], 404);
        return;
    }

    unset($user['password_hash']);
    Flight::json($user);
});

// GET /me - current logged-in user
Flight::route('GET /me', function () {
    $current = Flight::get('user');

    if (!$current) {
        Flight::haltJson(401, 'Not authenticated');
    }

    Flight::json($current);
});

// POST /users - create user (ADMIN ONLY)
Flight::route('POST /users', function () {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new UserService();

    $user = $service->createUser($data);
    Flight::json($user, 201);
});

// PUT /users/@id - update (ADMIN ONLY)
Flight::route('PUT /users/@id', function ($id) {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new UserService();

    $user = $service->updateUser($id, $data);
    if (!$user) {
        Flight::json(['error' => 'User not found'], 404);
        return;
    }

    Flight::json($user);
});

// DELETE /users/@id - delete (ADMIN ONLY)
Flight::route('DELETE /users/@id', function ($id) {
    Flight::requireRole('admin');

    $service = new UserService();
    $result  = $service->deleteUser($id);

    Flight::json($result);
});
