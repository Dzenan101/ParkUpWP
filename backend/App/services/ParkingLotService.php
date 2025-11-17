<?php
namespace App\services;

use App\dao\ParkingLotDao;

class ParkingLotService {

    private ParkingLotDao $dao;

    public function __construct() {
        $this->dao = new ParkingLotDao();
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        return $this->dao->getById($id);
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
