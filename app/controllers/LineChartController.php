<?php

class LineChartController extends Controller
{
    public function sendData() {
        if (isset($_POST["gender"]) && isset($_POST["state"])) {
            $gender = $_POST["gender"];
            $state = $_POST["state"];
        
            $chart = $this->model('LineChart');
            $result = $chart->getData($gender, $state);
            
            $output = array();
            foreach($result as $row => $row_value){
                foreach ($row_value as $info) {
                    $current_output = array();
                    foreach($info as $data){
                        $current_output[] = array(
                            'year'   => $data["year"],
                            'data_value'  => floatval($data["data_value"])
                            );
                    }
                    $output[$row] = $current_output;
                }
            }
        
            echo json_encode($output);
        }
        
    }

}