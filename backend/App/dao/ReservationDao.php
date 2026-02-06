<?php

namespace App\dao;

use App\Config\DB;

class ReservationDao
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM reservations");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    public function create(array $data): ?array
    {
        $stmt = $this->conn->prepare("
            INSERT INTO reservations (user_id, spot_id, start_time, end_time, status)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['user_id'],
            $data['spot_id'],
            $data['start_time'],
            $data['end_time'],
            $data['status'] ?? 'active',
        ]);

        return $this->getById($this->conn->lastInsertId());
    }

    public function update($id, array $data): ?array
    {
        $stmt = $this->conn->prepare("
            UPDATE reservations
            SET user_id = ?, spot_id = ?, start_time = ?, end_time = ?, status = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['user_id'],
            $data['spot_id'],
            $data['start_time'],
            $data['end_time'],
            $data['status'],
            $id,
        ]);

        return $this->getById($id);
    }

    public function delete($id): array
    {
        $stmt = $this->conn->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->execute([$id]);

        return ['deleted' => true];
    }
}
