<?php

use App\services\PaymentService;

// GET /payments - list all (logged-in)
Flight::route('GET /payments', function () {
    $service = new PaymentService();
    Flight::json($service->getAll());
});

// GET /payments/@id
Flight::route('GET /payments/@id', function ($id) {
    $service = new PaymentService();
    $payment = $service->getById($id);

    if ($payment === null) {
        Flight::json(['error' => 'Payment not found'], 404);
    } else {
        Flight::json($payment);
    }
});

// POST /payments - ADMIN ONLY
Flight::route('POST /payments', function () {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new PaymentService();

    $newPayment = $service->create($data);
    Flight::json($newPayment, 201);
});

// PUT /payments/@id - ADMIN ONLY
Flight::route('PUT /payments/@id', function ($id) {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new PaymentService();

    $updated = $service->update($id, $data);

    if ($updated === null) {
        Flight::json(['error' => 'Payment not found'], 404);
    } else {
        Flight::json($updated);
    }
});

// DELETE /payments/@id - ADMIN ONLY
Flight::route('DELETE /payments/@id', function ($id) {
    Flight::requireRole('admin');

    $service = new PaymentService();
    $result  = $service->delete($id);

    Flight::json($result);
});
