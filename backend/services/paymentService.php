<?php
namespace App\services;

use App\dao\PaymentDao;

class PaymentService {

    private PaymentDao $paymentDao;

    public function __construct() {
        $this->paymentDao = new PaymentDao();
    }

    public function getAllPayments() {
        return $this->paymentDao->getAllPayments();
    }

    public function getPaymentsByUser($user_id) {
        return $this->paymentDao->getPaymentsByUser($user_id);
    }
}
