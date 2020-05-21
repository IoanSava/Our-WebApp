<?php

class LineChartController extends Controller
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
        } else if (!isset($_POST["states"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "States not specified."));
        } else {
            $gender = $_POST["gender"];
            if ($this->checkGender($gender) != 0) {
                return;
            }
            $states = json_decode($_POST["states"]);

            $chart = $this->model('Chart');
            $result = array();
            foreach ($states as $state) {
                $currentStateDataValues = $chart->getDataByGenderAndState($gender, $state);
                $result[$state] = array($currentStateDataValues);
            }

            $output = array();
            foreach ($result as $row => $row_value) {
                foreach ($row_value as $info) {
                    $current_output = array();
                    foreach ($info as $data) {
                        $current_output[] = array(
                            'year'   => $data["year"],
                            'data_value'  => floatval($data["data_value"])
                        );
                    }
                    $output[$row] = $current_output;
                }
            }

            http_response_code(200); // ok
            echo json_encode($output);
        }
    }

    private function getFileName($states, $gender, $format)
    {
        $states = implode("_", $states);
        $filename = $states . "-" . $gender . "." . $format;
        return $filename;
    }

    public function exportCSV()
    {
        if (!isset($_GET["gender"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Gender not specified."));
        } else if (!isset($_GET["states"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "States not specified."));
        } else {
            $gender = $_GET["gender"];
            if ($this->checkGender($gender) != 0) {
                return;
            }

            $states = $_GET["states"];
            $states = explode(",", $states);

            header('Content-type: application/csv');

            $filename = $this->getFileName($states, $gender, "csv");
            header('Content-Disposition: attachment; filename=' . $filename);

            $filePointer = fopen('php://output', 'w');
            $header = array("State", "year", "data_value");
            fputcsv($filePointer, $header);

            $chart = $this->model('Chart');
            $result = array();
            foreach ($states as $state) {
                $currentStateDataValues = $chart->getDataByGenderAndState($gender, $state);
                $result[$state] = array($currentStateDataValues);
            }

            foreach ($result as $row => $row_value) {
                foreach ($row_value as $info) {
                    foreach ($info as $data) {
                        $current_output = array(
                            0   => $row,
                            1   => $data["year"],
                            2  => floatval($data["data_value"])
                        );
                        fputcsv($filePointer, $current_output);
                    }
                }
            }

            exit;
        }
    }
}
