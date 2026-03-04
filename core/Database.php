<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Database
{

    private static $connection = null;

    private function __construct()
    {
        static $host = "localhost";
        static $dbname = $_ENV['dbname'];
        static $username = "root";
        static $password = $_ENV['password'];


        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
    }

    public static function getConnection()
    {
        if (self::$connection === null) {
            new self();
        }
        return self::$connection;
    }
}