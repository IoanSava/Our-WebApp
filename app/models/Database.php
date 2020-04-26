<?php

/**
 * Singleton database
 */
class Database
{
    private static $instance = null;
    private $pdo;

    // database connection parameters
    private const HOST = 'sql7.freemysqlhosting.net';
    private const USERNAME = 'sql7335724';
    private const PASSWORD = 'cD3XyPN8WW';
    private const DATABASE = 'sql7335724';
    private const CHARSET = 'utf8mb4';

    private function __construct()
    {
        $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DATABASE . ";charset=" . self::CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, self::USERNAME, self::PASSWORD, $options);
        } catch (\PDOException $exception) {
            throw new \PDOException($exception->getMessage(), (int) $exception->getCode());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
