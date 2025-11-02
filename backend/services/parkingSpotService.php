<?php
namespace App\services;

use App\dao\ParkingSpotDao;

class ParkingSpotService {

    private ParkingSpotDao $parkingSpotDao;

    public function __construct() {
        $this->parkingSpotDao = new ParkingSpotDao();
    }

    public function getAllSpots() {
        return $this->parkingSpotDao->getAllSpots();
    }

    public function getSpotsByLotId($lot_id) {
        return $this->parkingSpotDao->getSpotsByLotId($lot_id);
    }
}
