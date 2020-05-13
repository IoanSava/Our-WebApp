<?php

class GeoChartController extends Controller
{
    private function checkGender($gender)
    {
        if (strcasecmp($gender, 'female') != 0 && strcasecmp($gender, 'male') != 0) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Invalid gender. Choose between female or male"));
            return -1;
        }
        return 0;
    }

    public function getData()
    {
        if (!isset($_POST["gender"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Gender not specified"));
        } else if (!isset($_POST["year"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Year not specified"));
        } else {
            $gender = $_POST["gender"];
            if ($this->checkGender($gender) != 0) {
                return;
            }

            $year = $_POST["year"];

            $chart = $this->model('Chart');
            $result = $chart->getDataByGenderAndYear($gender, $year);

            foreach ($result as $row) {
                $output[] = array(
                    'state'   => $row["state"],
                    'data_value'  => floatval($row["data_value"])
                );
            }

            http_response_code(200);
            echo json_encode($output);
        }
    }

    private function getFileName($year, $gender, $format)
    {
        $year = str_replace(' ', '_', $year);
        $filename = $year . "_" . $gender . "." . $format;
        return $filename;
    }

    public function exportCSV()
    {
        if (!isset($_GET["gender"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Gender not specified"));
        } else if (!isset($_GET["year"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Year not specified"));
        } else {
            $gender = $_GET["gender"];
            if ($this->checkGender($gender) != 0) {
                return;
            }
            $year = $_GET["year"];

            header('Content-type: application/csv');

            $filename = $this->getFileName($year, $gender, "csv");
            header('Content-Disposition: attachment; filename=' . $filename);

            $filePointer = fopen('php://output', 'w');
            $header = array("state", "data_value");
            fputcsv($filePointer, $header);

            $chart = $this->model('Chart');
            $result = $chart->getDataByGenderAndYear($gender, $year);

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
