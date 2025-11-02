<?php
namespace App\dao;

use App\config\DB;
use PDO;

class PaymentDao {

    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    // Get all payments
    public function getAllPayments() {
        $stmt = $this->conn->query("
            SELECT p.*, r.id AS reservation_id, u.full_name AS user_name, l.name AS lot_name
            FROM payments p
            JOIN reservations r ON p.reservation_id = r.id
            JOIN users u ON r.user_id = u.id
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots l ON s.lot_id = l.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get payments by user ID
    public function getPaymentsByUser($user_id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, r.id AS reservation_id, l.name AS lot_name
            FROM payments p
            JOIN reservations r ON p.reservation_id = r.id
            JOIN parking_spots s ON r.spot_id = s.id
            JOIN parking_lots l ON s.lot_id = l.id
            WHERE r.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new payment
    public function createPayment($reservation_id, $amount) {
        $stmt = $this->conn->prepare("
            INSERT INTO payments (reservation_id, amount)
            VALUES (?, ?)
        ");
        return $stmt->execute([$reservation_id, $amount]);
    }

    // Delete a payment
    public function deletePayment($id) {
        $stmt = $this->conn->prepare("DELETE FROM payments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
