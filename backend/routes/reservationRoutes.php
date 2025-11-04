<?php
use App\services\ReservationService;
use Flight;

// Get all reservations
Flight::route('GET /reservations', function() {
    $service = new ReservationService();
    Flight::json($service->getAllReservations());
});

// Get all reservations by user ID
Flight::route('GET /reservations/user/@user_id', function($user_id) {
    $service = new ReservationService();
    Flight::json($service->getReservationsByUser($user_id));
});
