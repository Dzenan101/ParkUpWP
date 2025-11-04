<?php
namespace App\config;

use PDO;
use PDOException;

class DB {
    public static function conn() {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=parking_db", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
