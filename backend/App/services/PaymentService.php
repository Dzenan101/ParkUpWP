<?php

namespace App\services;

use App\dao\PaymentDao;

class PaymentService
{
    private PaymentDao $dao;

    public function __construct()
    {
        $this->dao = new PaymentDao();
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
