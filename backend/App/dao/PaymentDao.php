<?php
namespace App\dao;

use App\Config\DB;
use PDO;

class PaymentDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    public function getAll() {
        $stmt = $this->conn->query("
            SELECT p.*, r.user_id, r.spot_id
            FROM payments p
            JOIN reservations r ON p.reservation_id = r.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, r.user_id, r.spot_id
            FROM payments p
            JOIN reservations r ON p.reservation_id = r.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO payments (reservation_id, amount)
            VALUES (?, ?)
        ");
        $stmt->execute([
            $data['reservation_id'],
            $data['amount']
        ]);

        return $this->getById($this->conn->lastInsertId());
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE payments
            SET reservation_id=?, amount=?
            WHERE id=?
        ");
        $stmt->execute([
            $data['reservation_id'],
            $data['amount'],
            $id
        ]);

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM payments WHERE id=?");
        $stmt->execute([$id]);

        return ["deleted" => true];
    }
}
