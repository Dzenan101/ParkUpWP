<?php
namespace App\dao;

class PaymentDao extends BaseDao {

    public function getAllPayments() {
        return $this->fetchAll("SELECT * FROM payments");
    }

    public function createPayment($data) {
        $sql = "INSERT INTO payments (reservation_id, amount, payment_time)
                VALUES (:reservation_id, :amount, :payment_time)";
        $this->execute($sql, $data);
    }

    public function updatePayment($id, $data) {
        $sql = "UPDATE payments 
                SET reservation_id = :reservation_id, amount = :amount, payment_time = :payment_time
                WHERE id = :id";
        $data['id'] = $id;
        $this->execute($sql, $data);
    }

    public function deletePayment($id) {
        $this->execute("DELETE FROM payments WHERE id = :id", [':id' => $id]);
    }
}
