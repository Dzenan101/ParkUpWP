<?php

namespace App\services;

use App\dao\ParkingLotDao;

class ParkingLotService
{
    private ParkingLotDao $dao;

    public function __construct()
    {
        $this->dao = new ParkingLotDao();
    }

    public function getAll(): array
    {
        return $this->dao->getAll();
    }

    public function getById($id): ?array
    {
        return $this->dao->getById($id);
    }

    public function create(array $data): ?array
    {
        return $this->dao->create($data);
    }

    public function update($id, array $data): ?array
    {
        return $this->dao->update($id, $data);
    }

    public function delete($id): array
    {
        return $this->dao->delete($id);
    }
}
