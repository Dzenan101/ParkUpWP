<?php

namespace App\dao;

use App\Config\DB;

class PaymentDao
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->conn->query("SELECT * FROM payments");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row === false ? null : $row;
    }

    public function create(array $data): ?array
    {
        // payment_time has default CURRENT_TIMESTAMP, so we don’t need to pass it
        $stmt = $this->conn->prepare("
            INSERT INTO payments (reservation_id, amount)
            VALUES (?, ?)
        ");

        $stmt->execute([
            $data['reservation_id'],
            $data['amount'],
        ]);

        return $this->getById($this->conn->lastInsertId());
    }

    public function update($id, array $data): ?array
    {
        $stmt = $this->conn->prepare("
            UPDATE payments
            SET reservation_id = ?, amount = ?, payment_time = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['reservation_id'],
            $data['amount'],
            $data['payment_time'],
            $id,
        ]);

        return $this->getById($id);
    }

    public function delete($id): array
    {
        $stmt = $this->conn->prepare("DELETE FROM payments WHERE id = ?");
        $stmt->execute([$id]);

        return ['deleted' => true];
    }
}
