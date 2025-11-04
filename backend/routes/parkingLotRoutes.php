<?php
use App\services\ParkingLotService;
use Flight;

// Get all parking lots
Flight::route('GET /parkinglots', function() {
    $service = new ParkingLotService();
    Flight::json($service->getAllLots());
});

// Get parking lot by ID
Flight::route('GET /parkinglots/@id', function($id) {
    $service = new ParkingLotService();
    Flight::json($service->getLotById($id));
});
