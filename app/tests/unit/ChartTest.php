<?php

use phpDocumentor\Reflection\Types\Array_;

require_once '../tests/../app/models/Chart.php';

final class ChartTest extends \PHPUnit_Framework_TestCase
{
    public function test1GetDataByGenderAndState()
    {
        $chart = new Chart();
        $result = $chart->getDataByGenderAndState("female", "AK");
        $this->assertSame(8, count($result));
    }



    /////////////////////////////////////?????? 
    //chiar daca declar un array in care pun exact rezultatul, tot nu e ok
    //pentru ca nu sunt puse virgulele unde trebuie

    // public function test2GetDataByGenderAndState()
    // {
    //     $chart = new Chart();
    //     $result = $chart->getDataByGenderAndState("female", "AK");
    //     $expected = "Array ( 
    //         0 => Array (
    //             'year' => 2011        
    //             'data_value' => '40.2'
    //         )
    //         1 => Array (
    //             'year' => 2012        
    //             'data_value' => '40.4'
    //         )
    //         2 => Array (
    //             'year' => 2013
    //             'data_value' => '39.6'
    //         )
    //         3 => Array (
    //             'year' => 2014
    //             'data_value' => '38.6'
    //         )
    //         4 => Array (
    //             'year' => 2015
    //             'data_value' => '37.17'
    //         )
    //         5 => Array (
    //             'year' => 2016
    //             'data_value' => '36.5'
    //         )
    //         6 => Array (
    //             'year' => 2017
    //             'data_value' => '36.14'
    //         )
    //         7 => Array (
    //             'year' => 2018
    //             'data_value' => '40.06'
    //         )
    //     )";
    //     $this->assertSame($expected, $result);
    // }

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

    /**
     * The idea behind the callMethod function:
        -access the private/protected method on the object to be tested
        -set its accessibility to true so it can be invoked.
        -invoke the private/protected method with its parameters if any
        -return the result.
     */
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