<?php
namespace App\services;

use App\dao\UserDao;

class UserService {

    private UserDao $dao;

    public function __construct() {
        $this->dao = new UserDao();
    }

    public function getAllUsers() {
        return $this->dao->getAllUsers();
    }

    public function getUserById($id) {
        return $this->dao->getUserById($id);
    }

    public function createUser($data) {
        return $this->dao->createUser($data);
    }

    public function updateUser($id, $data) {
        return $this->dao->updateUser($id, $data);
    }

    public function deleteUser($id) {
        return $this->dao->deleteUser($id);
    }
}
