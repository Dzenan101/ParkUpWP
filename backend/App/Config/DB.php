<?php

namespace App\Config;

class DB
{
    private static ?\PDO $connection = null;

    public static function getConnection(): \PDO
    {
        if (self::$connection === null) {
            $host = '127.0.0.1';        // XAMPP host
            $port = 3307;               // from your XAMPP screenshot
            $dbname = 'parking_db';       // your DB name
            $username = 'root';         // XAMPP default user
            $password = '';             // XAMPP default password (empty string)

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            try {
                self::$connection = new \PDO($dsn, $username, $password, [
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]);
            } catch (\PDOException $e) {
                die('DB connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
