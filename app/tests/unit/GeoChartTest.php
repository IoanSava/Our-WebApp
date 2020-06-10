<?php

require_once '../tests/../app/core/Controller.php';
require_once '../tests/../app/controllers/GeoChartController.php';

final class GeoChartTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckGenderFemale()
    {
        $geoChart = new GeoChartController();
        $expected = array('female');
        $this->assertSame(0, $this->callMethod($geoChart, 'checkGender', $expected));
    }

    public function testCheckGenderMale()
    {
        $geoChart = new GeoChartController();
        $expected = array('male');
        $this->assertSame(0, $this->callMethod($geoChart, 'checkGender', $expected));
    }

    public function testCheckGenderIncorrect()
    {
        $geoChart = new GeoChartController();
        $expected = array('alien');
        $this->assertSame(-1, $this->callMethod($geoChart, 'checkGender', $expected));
    }

    public function testGetFileNameCSV()
    {
        $geoChart = new GeoChartController();
        $expected = array("2016", "female", "csv");
        $this->assertSame("2016_female.csv", $this->callMethod($geoChart, 'getFileName', $expected));
    }

    public function testExportCSV()
    {
       $geoChart = new GeoChartController();
       $_GET['gender'] = 'female';
       $result = $geoChart->exportCSV();
       unset($_GET['gender']);
       $this->assertSame(400, http_response_code());
    }

    private function callMethod($object, string $method, array $parameters = [])
    {
        try {
            $className = get_class($object);
            $reflection = new \ReflectionClass($className);
        } catch (\ReflectionException $e) {
            throw new \Exception($e->getMessage());
        }

        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
