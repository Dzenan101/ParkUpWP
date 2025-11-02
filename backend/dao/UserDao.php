<?php
namespace App\dao;

use App\config\DB;
use PDO;

class UserDao {
    private PDO $conn;

    public function __construct() {
        $this->conn = DB::conn();
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
