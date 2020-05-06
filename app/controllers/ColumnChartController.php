<?php

class ColumnChartController extends Controller
{
    public function sendData() {
        if (isset($_POST["gender"]) && isset($_POST["state"])) {
            $gender = $_POST["gender"];
            $state = $_POST["state"];
        
            $chart = $this->model('ColumnChart');
            $result = $chart->getData($gender, $state);
            
            foreach ($result as $row) {
                $output[] = array(
                    'year'   => $row["year"],
                    'data_value'  => floatval($row["data_value"])
                );
            }
            echo json_encode($output);
        }
    }

    private function getFileName($state, $gender, $format) {
        $state = str_replace(' ', '_', $state);
        $filename = $state . "_" . $gender . "." . $format;
        return $filename;
    }

    public function exportCSV() {
        if (isset($_GET["gender"]) && isset($_GET["state"])) {
            $gender = $_GET["gender"];
            $state = $_GET["state"];
        
            header('Content-type: application/csv');
        
            $filename = $this->getFileName($state, $gender, "csv");
            header('Content-Disposition: attachment; filename='.$filename);
        
            $filePointer = fopen('php://output', 'w');
            $header = array("year", "data_value");
            fputcsv($filePointer, $header);
        
            $chart = $this->model('ColumnChart');
            $result = $chart->getData($gender, $state);
            
            foreach ($result as $row) {
                $output = array(
                    0 => $row["year"],
                    1 => $row["data_value"]
                );
                fputcsv($filePointer, $output);
            }
        
            exit;
        }
    }
}