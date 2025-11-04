<?php
use App\services\PaymentService;
use Flight;

// Get all payments
Flight::route('GET /payments', function() {
    $service = new PaymentService();
    Flight::json($service->getAllPayments());
});

// Get all payments for a specific user
Flight::route('GET /payments/user/@user_id', function($user_id) {
    $service = new PaymentService();
    Flight::json($service->getPaymentsByUser($user_id));
});
