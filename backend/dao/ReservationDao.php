<?php
namespace App\dao;

use App\config\DB;
use PDO;

class ReservationDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    // Get all reservations
    public function getAllReservations() {
        $stmt = $this->conn->query("
            SELECT r.*, u.full_name AS user_name, s.spot_number, l.name AS lot_name
            FROM reservations r
            JOIN users u ON r.user_id = u.id
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots l ON s.lot_id = l.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get reservations by user ID
    public function getReservationsByUser($user_id) {
        $stmt = $this->conn->prepare("
            SELECT r.*, s.spot_number, l.name AS lot_name
            FROM reservations r
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots l ON s.lot_id = l.id
            WHERE r.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a reservation
    public function createReservation($user_id, $spot_id, $start_time, $end_time) {
        $stmt = $this->conn->prepare("
            INSERT INTO reservations (user_id, spot_id, start_time, end_time)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$user_id, $spot_id, $start_time, $end_time]);
    }

    // Update reservation status (active/cancelled/completed)
    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("
            UPDATE reservations SET status = ? WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }

    // Delete a reservation
    public function deleteReservation($id) {
        $stmt = $this->conn->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
