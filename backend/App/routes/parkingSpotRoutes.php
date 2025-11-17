<?php

use Flight;
use App\services\ParkingSpotService;

$service = new ParkingSpotService();

// GET all
Flight::route('GET /parking-spots', function() use ($service) {
    Flight::json($service->getAll());
});

// GET by lot
Flight::route('GET /parking-spots/lot/@lot_id', function($lot_id) use ($service) {
    Flight::json($service->getByLot($lot_id));
});

// CREATE
Flight::route('POST /parking-spots', function() use ($service) {
    $data = Flight::request()->data->getData();
    Flight::json($service->create($data));
});

// UPDATE status
Flight::route('PUT /parking-spots/@id', function($id) use ($service) {
    $data = Flight::request()->data->getData();
    Flight::json($service->update($id, $data));
});

// DELETE
Flight::route('DELETE /parking-spots/@id', function($id) use ($service) {
    Flight::json($service->delete($id));
});
