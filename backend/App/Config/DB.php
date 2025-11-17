<?php

namespace App\Config;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $conn = null;

    public static function conn(): PDO
    {
        if (self::$conn === null) {
            $host = 'localhost:3307';
            $db   = 'parking_db';
            $user = 'root';
            $pass = ''; 

            try {
                self::$conn = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8",
                    $user,
                    $pass
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }

        return self::$conn;
    }
}
