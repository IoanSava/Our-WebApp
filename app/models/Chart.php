<?php

class Chart
{
    private $connection;

    public function __construct()
    {
        require_once 'Database.php';
        $this->connection = Database::getInstance()->getConnection();
    }

    public function getDataByGenderAndState($gender, $state)
    {
        $query = 'SELECT year, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(:gender))' .
            ' AND TRIM(UPPER(state_abbr)) = TRIM(UPPER(:state)) GROUP BY year ORDER BY year';
        $statement = $this->connection->prepare($query);

        $statement->execute([
            "gender" => $gender,
            "state" => $state
        ]);
        $result = $statement->fetchAll();
        return $result;
    }

    public function getDataByGenderAndYear($gender, $year)
    {
        $query = 'SELECT state, MAX(data_value) AS data_value FROM data WHERE TRIM(UPPER(break_out)) = TRIM(UPPER(:gender))' .
            ' AND year = :year GROUP BY state ORDER BY MAX(data_value) DESC';

        $statement = $this->connection->prepare($query);
        $statement->execute([
            "gender" => $gender,
            "year" => $year
        ]);
        $result = $statement->fetchAll();
        return $result;
    }

    private function getStateByAbbreviation($abbreviation)
    {
        $query = "SELECT DISTINCT state FROM data WHERE state_abbr = :state";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            "state" => $abbreviation
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result["state"];
    }

    public function insertRow($gender, $state, $year, $value)
    {
        $query = "INSERT INTO data (year, state_abbr, state, break_out, break_out_category, data_value)
         VALUES (:year, :state_abbr, :state, :break_out, :break_out_category, :data_value)";
        $statement = $this->connection->prepare($query);
        if ($statement->execute([
            "year" => $year,
            "state_abbr" => $state,
            "state" => $this->getStateByAbbreviation($state),
            "break_out" => $gender,
            "break_out_category" => "Gender",
            "data_value" => $value
        ])) {
            return 0; // ok
        }
        return -1; // error
    }
}
