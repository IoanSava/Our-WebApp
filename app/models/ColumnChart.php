<?php

class ColumnChart
{
    private $pdo;

    public function __construct()
    {
        require_once 'Database.php';
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function getData($gender, $state)
    {
        $query = 'SELECT year, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(?))' .
            ' AND TRIM(UPPER(state)) = TRIM(UPPER(?)) GROUP BY year ORDER BY year';
        $statement = $this->pdo->prepare($query);

        $statement->execute([$gender, $state]);
        $result = $statement->fetchAll();
        return $result;
    }
}
