<?php
namespace App\services;

use App\dao\ParkingLotDao;

class ParkingLotService {

    private ParkingLotDao $parkingLotDao;

    public function __construct() {
        $this->parkingLotDao = new ParkingLotDao();
    }

    public function getAllLots() {
        return $this->parkingLotDao->getAllLots();
    }

    public function getLotById($id) {
        return $this->parkingLotDao->getLotById($id);
    }
}
