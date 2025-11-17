<?php
namespace App\services;

use App\dao\ParkingSpotDao;

class ParkingSpotService {

    private ParkingSpotDao $dao;

    public function __construct() {
        $this->dao = new ParkingSpotDao();
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getByLot($lot_id) {
        return $this->dao->getByLot($lot_id);
    }

    public function create($data) {
        return $this->dao->create($data);
    }

    public function update($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
