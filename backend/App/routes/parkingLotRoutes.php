<?php

use Flight;
use App\services\ParkingLotService;

// GET all
Flight::route('GET /parking-lots', function () {
    $service = new ParkingLotService();
    Flight::json($service->getAll());
});

// GET by ID
Flight::route('GET /parking-lots/@id', function ($id) {
    $service = new ParkingLotService();
    Flight::json($service->getById($id));
});

// CREATE
Flight::route('POST /parking-lots', function () {
    $data = Flight::request()->data->getData();
    $service = new ParkingLotService();
    Flight::json($service->create($data));
});

// UPDATE
Flight::route('PUT /parking-lots/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $service = new ParkingLotService();
    Flight::json($service->update($id, $data));
});

// DELETE
Flight::route('DELETE /parking-lots/@id', function ($id) {
    $service = new ParkingLotService();
    Flight::json($service->delete($id));
});
