<?php

class GeoChart
{
    private $pdo;

    public function __construct()
    {
        require_once 'Database.php';
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function getData($gender, $year)
    {
        $query = 'SELECT state, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(?))' .
            ' AND year = ? GROUP BY state ORDER BY MAX(data_value) DESC';
        
        $statement = $this->pdo->prepare($query);
        $statement->execute([$gender, $year]);
        $result = $statement->fetchAll();
        return $result;
    }
}