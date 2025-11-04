<?php
namespace App\services;

use App\dao\UserDao;

class UserService {

    private UserDao $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    public function getAllUsers() {
        return $this->userDao->getAllUsers();
    }

    public function getUserById($id) {
        return $this->userDao->getUserById($id);
    }
}
