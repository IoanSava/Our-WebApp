<?php

require_once '../tests/../app/models/Chart.php';

final class ChartTest extends \PHPUnit\Framework\TestCase
{
    public function test1GetDataByGenderAndState()
    {
        $chart = new Chart();
        $result = $chart->getDataByGenderAndState("female", "AK");
        $this->assertSame(8, count($result));
    }

    public function testGetDataByGenderAndYear()
    {
       $chart = new Chart();
       $result = $chart->getDataByGenderAndYear("female", 2011);
       $this->assertSame(50, count($result));
    }

    public function test2GetDataByGenderAndYear()
    {
       $chart = new Chart();
       $result = $chart->getDataByGenderAndYear("female", 2020);
       $expected = array();
       $this->assertSame($expected, $result);
    }

    public function test1GetStateByAbbreviation(){
        $chart = new Chart();
        $expected = array('AK');
        $this->assertSame("Alaska", $this->callMethod($chart, 'getStateByAbbreviation', $expected));
    }

    public function test2GetStateByAbbreviation(){
        $chart = new Chart();
        $expected = array('FL');
        $this->assertSame("Florida", $this->callMethod($chart, 'getStateByAbbreviation', $expected));
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