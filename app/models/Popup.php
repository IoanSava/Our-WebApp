<?php

class Popup
{
    private $states;
    private $years;
    private $connection;

    public function __construct()
    {
        require_once 'Database.php';
        $this->connection = Database::getInstance()->getConnection();
        $this->initListOfStates();
        $this->initListOfYears();
    }

    private function initListOfStates()
    {
        $query = 'SELECT DISTINCT state, state_abbr FROM data';
        $statement = $this->connection->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
        $this->states = $result;
    }

    private function initListOfYears()
    {
        $query = 'SELECT DISTINCT year FROM data';
        $statement = $this->connection->prepare($query);

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
