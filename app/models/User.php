<?php

class User
{
    private $connection;

    public function __construct()
    {
        require_once 'Database.php';
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT id, username, email, password FROM users WHERE email = :email";
        $statement = $this->connection->prepare($query);
        $statement->execute(["email" => $email]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($email, $username, $password)
    {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $statement = $this->connection->prepare($query);
        if ($statement->execute([
            "email" => $email,
            "username" => $username,
            "password" => $password
        ])) {
            return 0; // ok
        }
        return -1; // error
    }
}
