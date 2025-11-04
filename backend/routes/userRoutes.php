<?php
use App\dao\UserDao;

Flight::route('/users', function() {
    $dao = new UserDao();
    $users = $dao->getAllUsers();
    Flight::json($users);
});
