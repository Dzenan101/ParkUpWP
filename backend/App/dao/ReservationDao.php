<?php
namespace App\dao;

use App\Config\DB;
use PDO;

class ReservationDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    public function getAll() {
        $sql = "
            SELECT r.*, u.full_name AS user_name, s.spot_number,
                   l.name AS lot_name
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots l ON s.lot_id = l.id
        ";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT r.*, u.full_name AS user_name, s.spot_number,
                l.name AS lot_name
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots l ON s.lot_id = l.id
            WHERE r.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO reservations (user_id, spot_id, start_time, end_time, status)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['user_id'],
            $data['spot_id'],
            $data['start_time'],
            $data['end_time'],
            $data['status'] ?? 'active'
        ]);

        return $this->getById($this->conn->lastInsertId());
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE reservations
            SET user_id=?, spot_id=?, start_time=?, end_time=?, status=?
            WHERE id=?
        ");

        $stmt->execute([
            $data['user_id'],
            $data['spot_id'],
            $data['start_time'],
            $data['end_time'],
            $data['status'],
            $id
        ]);

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM reservations WHERE id=?");
        $stmt->execute([$id]);
        return ["deleted" => true];
    }
}
