<?php

class ColumnChartController extends Controller
{
    private function checkGender($gender)
    {
        if (strcasecmp($gender, 'female') != 0 && strcasecmp($gender, 'male') != 0) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Invalid gender. Choose between female or male."));
            return -1;
        }
        return 0;
    }

    public function getData()
    {
        if (!isset($_POST["gender"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Gender not specified."));
        } else if (!isset($_POST["state"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "State not specified."));
        } else {
            $gender = $_POST["gender"];
            if ($this->checkGender($gender) != 0) {
                return;
            }

            $state = $_POST["state"];

            $chart = $this->model('Chart');
            $result = $chart->getDataByGenderAndState($gender, $state);

            if (!empty($result)) {
                foreach ($result as $row) {
                    $output[] = array(
                        'year'   => $row["year"],
                        'data_value'  => floatval($row["data_value"])
                    );
                }

                http_response_code(200); // ok
                echo json_encode($output);
            } else {
                http_response_code(404); // not found
                echo json_encode(array("message" => "Data not found."));
            }
        }
    }

    private function getFileName($state, $gender, $format)
    {
        $state = str_replace(' ', '_', $state);
        $filename = $state . "_" . $gender . "." . $format;
        return $filename;
    }

    public function exportCSV()
    {
        if (!isset($_GET["gender"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Gender not specified."));
        } else if (!isset($_GET["state"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "State not specified."));
        } else {
            $gender = $_GET["gender"];
            if ($this->checkGender($gender) != 0) {
                return;
            }

            $state = $_GET["state"];

            header('Content-type: application/csv');

            $filename = $this->getFileName($state, $gender, "csv");
            header('Content-Disposition: attachment; filename=' . $filename);

            $filePointer = fopen('php://output', 'w');
            $header = array("year", "data_value");
            fputcsv($filePointer, $header);

            $chart = $this->model('Chart');
            $result = $chart->getDataByGenderAndState($gender, $state);

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
