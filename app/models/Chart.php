<?php

class Chart
{
    private $pdo;

    public function __construct()
    {
        require_once 'Database.php';
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function getDataByGenderAndState($gender, $state)
    {
        $query = 'SELECT year, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(?))' .
            ' AND TRIM(UPPER(state_abbr)) = TRIM(UPPER(?)) GROUP BY year ORDER BY year';
        $statement = $this->pdo->prepare($query);

        $statement->execute([$gender, $state]);
        $result = $statement->fetchAll();
        return $result;
    }

    public function getDataByGenderAndYear($gender, $year)
    {
        $query = 'SELECT state, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(?))' .
            ' AND year = ? GROUP BY state ORDER BY MAX(data_value) DESC';

        $statement = $this->pdo->prepare($query);
        $statement->execute([$gender, $year]);
        $result = $statement->fetchAll();
        return $result;
    }
}
