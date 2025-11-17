<?php
namespace App\services;

use App\dao\PaymentDao;

class PaymentService {

    private PaymentDao $dao;

    public function __construct() {
        $this->dao = new PaymentDao();
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
