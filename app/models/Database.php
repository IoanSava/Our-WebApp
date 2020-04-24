<?php

/**
 * Singleton database
 */
class Database
{
    private static $instance = null;
    private $connection;

    // database connection parameters
    private const SERVER_LOCATION = 'db4free.net';
    private const USERNAME = 'student_2020';
    private const PASSWORD = 'obis_UAIC2020';
    private const DATABASE = 'obis_2020';

    private function __construct()
    {
        // MySQL connection
        $this->connection = new mysqli(
            self::SERVER_LOCATION,
            self::USERNAME,
            self::PASSWORD,
            self::DATABASE
        );

        if (mysqli_connect_errno()) {
            die('Connection failed');
        }
    }

    function __destruct()
    {
        $this->connection->close();
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
