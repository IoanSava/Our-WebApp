<?php

require_once '../tests/../app/core/Controller.php';
require_once '../tests/../app/controllers/ColumnChartController.php';

final class ColumnChartTest extends \PHPUnit\Framework\TestCase
{
    public function testCheckGenderFemale()
    {
        $columnChart = new ColumnChartController();
        $expected = array('female');
        $this->assertSame(0, $this->callMethod($columnChart, 'checkGender', $expected));
    }

    public function testCheckGenderMale()
    {
        $columnChart = new ColumnChartController();
        $expected = array('male');
        $this->assertSame(0, $this->callMethod($columnChart, 'checkGender', $expected));
    }

    public function testCheckGenderIncorrect()
    {
        $columnChart = new ColumnChartController();
        $expected = array('gender');
        $this->assertSame(-1, $this->callMethod($columnChart, 'checkGender', $expected));
    }

    public function testExportCSV()
    {
        $columnChart = new ColumnChartController();
        $result = $columnChart->exportCSV();
        $this->assertSame(null, $result);
    }

    public function testGetFileNameCSV()
    {
        $columnChart = new ColumnChartController();
        $expected = array("AK", "female", "csv");
        $this->assertSame("AK_female.csv", $this->callMethod($columnChart, 'getFileName', $expected));
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