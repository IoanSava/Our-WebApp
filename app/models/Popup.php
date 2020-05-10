<?php

class Popup
{
    private $states;
    private $years;
    private $pdo;

    public function __construct()
    {
        require_once 'Database.php';
        $this->pdo = Database::getInstance()->getPDO();
        $this->initListOfStates();
        $this->initListOfYears();
    }

    private function initListOfStates()
    {
        $query = 'SELECT DISTINCT state, state_abbr FROM data';
        $statement = $this->pdo->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
        $this->states = $result;
    }

    private function initListOfYears()
    {
        $query = 'SELECT DISTINCT year FROM data';
        $statement = $this->pdo->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN);
        $this->years = $result;
    }

    public function getListOfStates()
    {
        return $this->states;
    }

    public function getListOfYears()
    {
        return $this->years;
    }
}
