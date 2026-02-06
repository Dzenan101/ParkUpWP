<?php

namespace App\services;

use App\dao\UserDao;

class UserService
{
    private UserDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function getAllUsers(): array
    {
        return $this->userDao->getAllUsers();
    }

    public function getUserById($id): ?array
    {
        return $this->userDao->getUserById($id);
    }

    // ---------- AUTH RELATED ----------

    public function register(array $data): array
    {
        // basic validation (you can improve later)
        if (empty($data['email']) || empty($data['password']) || empty($data['full_name'])) {
            throw new \Exception('full_name, email and password are required');
        }

        // email must be unique
        if ($this->userDao->getUserByEmail($data['email'])) {
            throw new \Exception('Email already registered');
        }

        // hash password
        $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password']); // don't store plain password

        $user = $this->userDao->createUser($data);

        // never expose password_hash
        unset($user['password_hash']);

        return $user;
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userDao->getUserByEmail($email);

        if (!$user) {
            throw new \Exception('Invalid email or password');
        }

        if (!password_verify($password, $user['password_hash'])) {
            throw new \Exception('Invalid email or password');
        }

        // remove hash before returning
        unset($user['password_hash']);

        return $user;
    }

    // ---------- CRUD used by admin ----------

    public function createUser(array $data): ?array
    {
        // for admin-created users we also hash password from 'password'
        if (!empty($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);
        }

        $user = $this->userDao->createUser($data);
        unset($user['password_hash']);
        return $user;
    }

    public function updateUser($id, array $data): ?array
    {
        $user = $this->userDao->updateUser($id, $data);
        if ($user) {
            unset($user['password_hash']);
        }
        return $user;
    }

    public function deleteUser($id): array
    {
        return $this->userDao->deleteUser($id);
    }
}
