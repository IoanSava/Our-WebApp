<?php

class ChartController extends Controller
{
    private function getHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function insertRow()
    {
        $this->getHeaders();
        $data = json_decode(file_get_contents("php://input"));

        require_once 'UserController.php';
        $userController = new UserController;
        $userController->checkJWT($data);

        if (!empty($data->gender) && !empty($data->state) && !empty($data->year) && !empty($data->value)) {
            $chartModel = $this->model('Chart');

            $result = $chartModel->insertRow($data->gender, $data->state, $data->year, $data->value);

            if ($result == 0) {
                http_response_code(201); // created
                echo json_encode(array("message" => "Row inserted"));
            } else {
                http_response_code(504); //  gateway timeout
                echo json_encode(array("message" => "Unable to insert row"));
            }

        } else {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Unable to insert row. Not enough data provided."));
        }
    }

    public function updateRow()
    {
        // update data_value of row by (state, year, gender)
    }

    public function deleteRow()
    {
        // delete row by (state, year, gender, data_value)
    }
}
