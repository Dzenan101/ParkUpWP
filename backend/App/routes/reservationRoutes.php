<?php

use App\services\ReservationService;

// GET /reservations - list all (logged-in)
Flight::route('GET /reservations', function () {
    $service = new ReservationService();
    Flight::json($service->getAll());
});

// GET /reservations/@id
Flight::route('GET /reservations/@id', function ($id) {
    $service = new ReservationService();
    $res     = $service->getById($id);

    if ($res === null) {
        Flight::json(['error' => 'Reservation not found'], 404);
    } else {
        Flight::json($res);
    }
});

// POST /reservations - ADMIN ONLY
Flight::route('POST /reservations', function () {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new ReservationService();

    $newRes = $service->create($data);
    Flight::json($newRes, 201);
});

// PUT /reservations/@id - ADMIN ONLY
Flight::route('PUT /reservations/@id', function ($id) {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new ReservationService();

    $updated = $service->update($id, $data);

    if ($updated === null) {
        Flight::json(['error' => 'Reservation not found'], 404);
    } else {
        Flight::json($updated);
    }
});

// DELETE /reservations/@id - ADMIN ONLY
Flight::route('DELETE /reservations/@id', function ($id) {
    Flight::requireRole('admin');

    $service = new ReservationService();
    $result  = $service->delete($id);

    Flight::json($result);
});
