<?php

class Popup
{
    private $states;
    private $pdo;

    public function __construct()
    {
        require_once 'Database.php';
        $this->pdo = Database::getInstance()->getPDO();
        $this->initListOfStates();
    }

    private function initListOfStates()
    {
        $query = 'SELECT DISTINCT state FROM data';
        $statement = $this->pdo->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN);
        $this->states = $result;
    }

    public function getListOfStates()
    {
        return $this->states;
    }
}
