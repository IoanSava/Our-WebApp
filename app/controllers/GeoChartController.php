<?php

class GeoChartController extends Controller
{
    public function sendData() {
        if (isset($_POST["gender"]) && isset($_POST["year"])) {
            $gender = $_POST["gender"];
            $year = $_POST["year"];
        
            $chart = $this->model('GeoChart');
            $result = $chart->getData($gender, $year);
            
            foreach ($result as $row) {
                $output[] = array(
                    'state'   => $row["state"],
                    'data_value'  => floatval($row["data_value"])
                );
            }
            echo json_encode($output);
        }
    }

    private function getFileName($year, $gender, $format) {
        $year = str_replace(' ', '_', $year);
        $filename = $year . "_" . $gender . "." . $format;
        return $filename;
    }

    public function exportCSV() {
        if (isset($_GET["gender"]) && isset($_GET["year"])) {
            $gender = $_GET["gender"];
            $year = $_GET["year"];
        
            header('Content-type: application/csv');
        
            $filename = $this->getFileName($year, $gender, "csv");
            header('Content-Disposition: attachment; filename='.$filename);
        
            $filePointer = fopen('php://output', 'w');
            $header = array("state", "data_value");
            fputcsv($filePointer, $header);
        
            $chart = $this->model('GeoChart');
            $result = $chart->getData($gender, $year);
            
            foreach ($result as $row) {
                $output = array(
                    0 => $row["state"],
                    1 => $row["data_value"]
                );
                fputcsv($filePointer, $output);
            }
        
            exit;
        }
    }
}