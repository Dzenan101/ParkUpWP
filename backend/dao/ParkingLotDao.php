<?php
namespace App\dao;

use App\config\DB;
use PDO;

class ParkingLotDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    // Get all parking lots
    public function getAllLots() {
        $stmt = $this->conn->query("SELECT * FROM parking_lots");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get one parking lot by ID
    public function getLotById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM parking_lots WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create new parking lot
    public function createLot($name, $location, $total_spots, $price_per_hour) {
        $stmt = $this->conn->prepare("
            INSERT INTO parking_lots (name, location, total_spots, price_per_hour)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $location, $total_spots, $price_per_hour]);
    }

    // Update parking lot
    public function updateLot($id, $name, $location, $total_spots, $price_per_hour) {
        $stmt = $this->conn->prepare("
            UPDATE parking_lots 
            SET name = ?, location = ?, total_spots = ?, price_per_hour = ?
            WHERE id = ?
        ");
        return $stmt->execute([$name, $location, $total_spots, $price_per_hour, $id]);
    }

    // Delete parking lot
    public function deleteLot($id) {
        $stmt = $this->conn->prepare("DELETE FROM parking_lots WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
