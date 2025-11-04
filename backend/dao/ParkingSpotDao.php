<?php
namespace App\dao;

use App\config\DB;
use PDO;

class ParkingSpotDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    // Get all parking spots
    public function getAllSpots() {
        $stmt = $this->conn->query("SELECT * FROM parking_spots");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all spots by parking lot ID
    public function getSpotsByLotId($lot_id) {
        $stmt = $this->conn->prepare("SELECT * FROM parking_spots WHERE lot_id = ?");
        $stmt->execute([$lot_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new parking spot
    public function createSpot($lot_id, $spot_number, $status = 'available') {
        $stmt = $this->conn->prepare("
            INSERT INTO parking_spots (lot_id, spot_number, status)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$lot_id, $spot_number, $status]);
    }

    // Update a parking spot status
    public function updateSpotStatus($id, $status) {
        $stmt = $this->conn->prepare("
            UPDATE parking_spots 
            SET status = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    // Delete a parking spot
    public function deleteSpot($id) {
        $stmt = $this->conn->prepare("DELETE FROM parking_spots WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
