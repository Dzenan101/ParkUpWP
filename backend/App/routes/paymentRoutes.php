<?php

use Flight;
use App\services\PaymentService;

$service = new PaymentService();

// GET all
Flight::route('GET /payments', function() use ($service) {
    Flight::json($service->getAll());
});

// GET by ID
Flight::route('GET /payments/@id', function($id) use ($service) {
    Flight::json($service->getById($id));
});

// CREATE
Flight::route('POST /payments', function() use ($service) {
    $data = Flight::request()->data->getData();
    Flight::json($service->create($data));
});

// UPDATE
Flight::route('PUT /payments/@id', function($id) use ($service) {
    $data = Flight::request()->data->getData();
    Flight::json($service->update($id, $data));
});

// DELETE
Flight::route('DELETE /payments/@id', function($id) use ($service) {
    Flight::json($service->delete($id));
});
