<?php

require_once '../tests/../app/core/Controller.php';
require_once '../tests/../app/controllers/LineChartController.php';

final class LineChartTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckGenderFemale()
    {
        $lineChart = new LineChartController();
        $expected = array('female');
        $this->assertSame(0, $this->callMethod($lineChart, 'checkGender', $expected));
    }

    public function testCheckGenderMale()
    {
        $lineChart = new LineChartController();
        $expected = array('male');
        $this->assertSame(0, $this->callMethod($lineChart, 'checkGender', $expected));
    }

    public function testCheckGenderIncorrect()
    {
        $lineChart = new LineChartController();
        $expected = array('geneder');
        $this->assertSame(-1, $this->callMethod($lineChart, 'checkGender', $expected));
    }

    public function testGetFileNameCSV()
    {
        $lineChart = new LineChartController();
        $expected = array(array("AK", "FL"), "female", "csv");
        $this->assertSame("AK_FL-female.csv", $this->callMethod($lineChart, 'getFileName', $expected));
    }

    public function testGetFileNameSVG()
    {
        $lineChart = new LineChartController();
        $expected = array(array("AK", "FL", "AL"), "female", "svg");
        $this->assertSame("AK_FL_AL-female.svg", $this->callMethod($lineChart, 'getFileName', $expected));
    }

    public function testGetFileNameWEBP()
    {
        $lineChart = new LineChartController();
        $expected = array(array("AK", "FL", "AL", "HW"), "female", "webp");
        $this->assertSame("AK_FL_AL_HW-female.webp", $this->callMethod($lineChart, 'getFileName', $expected));
    }

    public function testExportCSV()
    {
       $lineChart = new LineChartController();
       $result = $lineChart->exportCSV();
       $this->assertSame(null, $result);
    }

    private function callMethod($object, string $method , array $parameters = [])
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