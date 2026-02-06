<?php

use App\services\ParkingLotService;

// GET /parking-lots - list all (public, already allowed in middleware)
Flight::route('GET /parking-lots', function () {
    $service = new ParkingLotService();
    Flight::json($service->getAll());
});

// GET /parking-lots/@id - single lot (public)
Flight::route('GET /parking-lots/@id', function ($id) {
    $service = new ParkingLotService();
    $lot     = $service->getById($id);

    if ($lot === null) {
        Flight::json(['error' => 'Parking lot not found'], 404);
    } else {
        Flight::json($lot);
    }
});

// POST /parking-lots - create (ADMIN ONLY)
Flight::route('POST /parking-lots', function () {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new ParkingLotService();

    $newLot = $service->create($data);
    Flight::json($newLot, 201);
});

// PUT /parking-lots/@id - update (ADMIN ONLY)
Flight::route('PUT /parking-lots/@id', function ($id) {
    Flight::requireRole('admin');

    $data    = Flight::request()->data->getData();
    $service = new ParkingLotService();

    $updated = $service->update($id, $data);

    if ($updated === null) {
        Flight::json(['error' => 'Parking lot not found'], 404);
    } else {
        Flight::json($updated);
    }
});

// DELETE /parking-lots/@id - delete (ADMIN ONLY)
Flight::route('DELETE /parking-lots/@id', function ($id) {
    Flight::requireRole('admin');

    $service = new ParkingLotService();
    $result  = $service->delete($id);

    Flight::json($result);
});
