<?php

namespace App\dao;

use App\Config\DB;

class ParkingSpotDao
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM parking_spots");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM parking_spots WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    public function create(array $data): ?array
    {
        $stmt = $this->conn->prepare("
            INSERT INTO parking_spots (lot_id, spot_number, status)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $data['lot_id'],
            $data['spot_number'],
            $data['status'] ?? 'available',
        ]);

        return $this->getById($this->conn->lastInsertId());
    }

    public function update($id, array $data): ?array
    {
        $stmt = $this->conn->prepare("
            UPDATE parking_spots
            SET lot_id = ?, spot_number = ?, status = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['lot_id'],
            $data['spot_number'],
            $data['status'],
            $id,
        ]);

        return $this->getById($id);
    }

    public function delete($id): array
    {
        $stmt = $this->conn->prepare("DELETE FROM parking_spots WHERE id = ?");
        $stmt->execute([$id]);

        return ['deleted' => true];
    }
}
