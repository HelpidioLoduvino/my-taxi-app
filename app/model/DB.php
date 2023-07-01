<?php
class DB
{
    private static $host = 'localhost';
    private static $dbname = 'my_taxi_db';
    private static $username = 'myuser';
    private static $password = 'mypassword';

    public static function getConnection()
    {
        $dsn = "pgsql:host=" . self::$host . ";dbname=" . self::$dbname;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $connection = new PDO($dsn, self::$username, self::$password, $options);

            return $connection;
        } catch (PDOException $e) {
            exit('Database connection failed: ' . $e->getMessage());
        }
    }
}

