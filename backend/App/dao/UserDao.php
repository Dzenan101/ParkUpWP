<?php
namespace App\dao;

use App\Config\DB;
use PDO;

class UserDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO users (full_name,email,password_hash,role,phone)
            VALUES (?,?,?,?,?)
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

    public function updateUser($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE users SET full_name=?, email=?, phone=? WHERE id=?
        ");
        $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $id
        ]);

        return $this->getUserById($id);
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([$id]);

        return ["deleted" => true];
    }
}
