<?php

use App\services\ParkingSpotService;

// GET /parking-spots - list all (logged-in, checked by middleware)
Flight::route('GET /parking-spots', function () {
    $service = new ParkingSpotService();
    Flight::json($service->getAll());
});

// GET /parking-spots/@id
Flight::route('GET /parking-spots/@id', function ($id) {
    $service = new ParkingSpotService();
    $spot    = $service->getById($id);

    if ($spot === null) {
        Flight::json(['error' => 'Parking spot not found'], 404);
    } else {
        Flight::json($spot);
    }
});

// POST /parking-spots - ADMIN ONLY
Flight::route('POST /parking-spots', function () {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new ParkingSpotService();

    $newSpot = $service->create($data);
    Flight::json($newSpot, 201);
});

// PUT /parking-spots/@id - ADMIN ONLY
Flight::route('PUT /parking-spots/@id', function ($id) {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new ParkingSpotService();

    $updated = $service->update($id, $data);

    if ($updated === null) {
        Flight::json(['error' => 'Parking spot not found'], 404);
    } else {
        Flight::json($updated);
    }
});

// DELETE /parking-spots/@id - ADMIN ONLY
Flight::route('DELETE /parking-spots/@id', function ($id) {
    Flight::requireRole('admin');

    $service = new ParkingSpotService();
    $result  = $service->delete($id);

    Flight::json($result);
});
