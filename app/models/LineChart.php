<?php

class LineChart
{
    private $pdo;

    public function __construct()
    {
        require_once 'Database.php';
        $this->pdo = Database::getInstance()->getPDO();
    }

    public function getData($gender, $states)
    {
        //$in = str_repeat('TRIM(UPPER(?)),', count($states) - 1) . 'TRIM(UPPER(?))';
        //echo $in;
        $result = array();
        foreach ($states as $state) {
            $query = "SELECT year, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(?))" .
            " AND TRIM(UPPER(state)) = TRIM(UPPER(?)) GROUP BY year ORDER BY year";
        
            $statement = $this->pdo->prepare($query);
            $statement->execute([$gender, $state]);
            $state_infos = $statement->fetchAll();
            $result[$state] = array($state_infos);
        }

       // $result = array($state => array( $state_infos));
        //$result = $statement->fetchAll();
        return $result;
    }
}
