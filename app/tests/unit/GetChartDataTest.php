<?php

require_once '../tests/../app/core/Controller.php';
require_once '../tests/../app/controllers/getChartData.php';

final class GetChartDataTest extends \PHPUnit\Framework\TestCase
{

    public function testIndexMissingChartType()
    {
        $getChartData = new GetChartData();
        $expected = '{"message":"A chart type must be specified."}';
        $this->expectOutputString($expected);
        $getChartData->index();
    }

    public function testIndexMissingGender()
    {
        $getChartData = new GetChartData();
        $expected = '{"message":"Gender not specified."}';
        $this->expectOutputString($expected);
        $_POST['chart_type'] = 'geo';
        $getChartData->index();
        unset($_POST['chart_type']);
    }

    public function testIndexInvalidChartType()
    {
        $getChartData = new GetChartData();
        $expected = '{"message":"Wrong chart type."}';
        $this->expectOutputString($expected);
        $_POST['chart_type'] = 'table';
        $_POST['gender'] = 'female';
        $getChartData->index();
        unset($_POST['chart_type']);
        unset($_POST['gender']);
    }

    public function testIndexMissingStateForColumnChart(){
        $getChartData = new GetChartData();
        $expected = '{"message":"State not specified."}';
        $this->expectOutputString($expected);
        $_POST['chart_type'] = 'column';
        $_POST['gender'] = 'female';
        $getChartData->index();
        unset($_POST['chart_type']);
        unset($_POST['gender']);
    }

    public function testIndexMissingStatesForLineChart(){
        $getChartData = new GetChartData();
        $expected = '{"message":"States not specified."}';
        $this->expectOutputString($expected);
        $_POST['chart_type'] = 'line';
        $_POST['gender'] = 'female';
        $getChartData->index();
        unset($_POST['chart_type']);
        unset($_POST['gender']);
    }

    public function testIndexMissingYearForGeoChart(){
        $getChartData = new GetChartData();
        $expected = '{"message":"Year not specified."}';
        $this->expectOutputString($expected);
        $_POST['chart_type'] = 'geo';
        $_POST['gender'] = 'female';
        $getChartData->index();
        unset($_POST['chart_type']);
        unset($_POST['gender']);
    }

    public function testIndexValidRequestButDataNotFoundForColumnChart(){
        $getChartData = new GetChartData();
        $_POST['chart_type'] = 'column';
        $_POST['gender'] = 'female';
        $_POST['state'] = 'RU';
        $getChartData->index();
        unset($_POST['chart_type']);
        unset($_POST['gender']);
        unset($_POST['state']);
        $this->assertSame(404, http_response_code());
    }

    public function testIndexValidRequestAndDataFoundForColumnChart(){
        $getChartData = new GetChartData();
        $_POST['chart_type'] = 'column';
        $_POST['gender'] = 'female';
        $_POST['state'] = 'AK';
        $getChartData->index();
        unset($_POST['chart_type']);
        unset($_POST['gender']);
        unset($_POST['state']);
        $this->assertSame(200, http_response_code());
    }
}
