<?php
namespace App\dao;

use App\Config\DB;
use PDO;

class ParkingSpotDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM parking_spots")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByLot($lot_id) {
        $stmt = $this->conn->prepare("SELECT * FROM parking_spots WHERE lot_id = ?");
        $stmt->execute([$lot_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO parking_spots (lot_id, spot_number, status)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([
            $data['lot_id'],
            $data['spot_number'],
            $data['status'] ?? 'available'
        ]);
        return ["created" => true];
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE parking_spots SET status = ? WHERE id = ?");
        $stmt->execute([$data['status'], $id]);
        return ["updated" => true];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM parking_spots WHERE id=?");
        $stmt->execute([$id]);
        return ["deleted" => true];
    }
}
