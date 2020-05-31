<?php

class GetChartData extends Controller
{

    public function index()
    {
        if(!isset($_POST["chart_type"])){
            http_response_code(400); // bad request
            echo json_encode(array("message" => "A chart type must be specified."));
        } else if (!isset($_POST["gender"])) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Gender not specified."));
        } else {
            switch(strtolower($_POST["chart_type"])){
                case "column":
                    if (!isset($_POST["state"])) {
                        http_response_code(400); // bad request
                        echo json_encode(array("message" => "State not specified."));
                    } else {
                        require_once 'ColumnChartController.php';
                        $controller = new ColumnChartController;
                        $controller->getData(['gender' => $_POST['gender'], 'state' => $_POST['state']]);
                    }
                    break;
                case "geo":
                    if (!isset($_POST["year"])) {
                        http_response_code(400); // bad request
                        echo json_encode(array("message" => "Year not specified."));
                    } else {
                        require_once 'GeoChartController.php';
                        $controller = new GeoChartController;
                        $controller->getData(['gender' => $_POST['gender'], 'year' => $_POST['year']]);
                    }
                    break;
                case "line":
                     if (!isset($_POST["states"])) {
                        http_response_code(400); // bad request
                        echo json_encode(array("message" => "States not specified."));
                    } else {
                        require_once 'LineChartController.php';
                        $controller = new LineChartController;
                        $controller->getData(['gender' => $_POST['gender'], 'states' => $_POST['states']]);
                    }
                    break;    
                default:
                http_response_code(400); // bad request
                echo json_encode(array("message" => "Wrong chart type."));
                break;
            }
        }
    }
}
