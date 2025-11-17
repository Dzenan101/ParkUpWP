<?php
namespace App\dao;

use App\Config\DB;
use PDO;

class ParkingLotDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM parking_lots");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM parking_lots WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO parking_lots (name, location, total_spots, price_per_hour)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['name'],
            $data['location'],
            $data['total_spots'],
            $data['price_per_hour']
        ]);

        return $this->getById($this->conn->lastInsertId());
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE parking_lots
            SET name=?, location=?, total_spots=?, price_per_hour=?
            WHERE id=?
        ");

        $stmt->execute([
            $data['name'],
            $data['location'],
            $data['total_spots'],
            $data['price_per_hour'],
            $id
        ]);

        return $this->getById($id);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM parking_lots WHERE id=?");
        $stmt->execute([$id]);
        return ["deleted" => true];
    }
}
