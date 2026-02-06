<?php

namespace App\dao;

use App\Config\DB;

class UserDao
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function getAllUsers(): array
    {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserById($id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    public function createUser(array $data): ?array
    {
        $stmt = $this->conn->prepare("
            INSERT INTO users (full_name, email, password_hash, role, phone)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['password_hash'],
            $data['role'] ?? 'user',
            $data['phone'] ?? null
        ]);

        return $this->getUserById($this->conn->lastInsertId());
    }

    public function updateUser($id, array $data): ?array
    {
        $stmt = $this->conn->prepare("
            UPDATE users SET full_name = ?, email = ?, phone = ? WHERE id = ?
        ");

        $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $id
        ]);

        return $this->getUserById($id);
    }

    public function deleteUser($id): array
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return ['deleted' => true];
    }
}
