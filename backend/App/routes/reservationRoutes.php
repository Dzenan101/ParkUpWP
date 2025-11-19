<?php

use Flight;
use App\services\ReservationService;

$service = new ReservationService();

// GET ALL
Flight::route('GET /reservations', function() use ($service) {
    Flight::json($service->getAll());
});

// GET BY ID
Flight::route('GET /reservations/@id', function($id) use ($service) {
    Flight::json($service->getById($id));
});

// CREATE
Flight::route('POST /reservations', function() use ($service) {
    $data = Flight::request()->data->getData();
    Flight::json($service->create($data));
});

// UPDATE
Flight::route('PUT /reservations/@id', function($id) use ($service) {
    $data = Flight::request()->data->getData();
    Flight::json($service->update($id, $data));
});

// DELETE
Flight::route('DELETE /reservations/@id', function($id) use ($service) {
    Flight::json($service->delete($id));
});
