<?php

if (isset($_POST["gender"]) && isset($_POST["state"])) {
    $gender = $_POST["gender"];
    $state = $_POST["state"];

    require_once '../models/ColumnChart.php';
    $chart = new ColumnChart;
    $result = $chart->getData($gender, $state);
    
    foreach ($result as $row) {
        $output[] = array(
            'year'   => $row["year"],
            'data_value'  => floatval($row["data_value"])
        );
    }
    echo json_encode($output);
}
