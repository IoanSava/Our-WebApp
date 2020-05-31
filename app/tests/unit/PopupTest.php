<?php

require_once '../tests/../app/models/Popup.php';

final class PopupTest extends \PHPUnit_Framework_TestCase
{
    public function test50States()
    {
        $popup = new Popup;
        $states = $popup->getListOfStates();
        $this->assertSame(50, count($states));
    }

    public function testMinimumYear()
    {
        $popup = new Popup;
        $years = $popup->getListOfYears();
        $this->assertSame(2011, min($years));
    }

    public function testMaximumYear()
    {
        $popup = new Popup;
        $years = $popup->getListOfYears();
        $this->assertSame(2018, max($years));
    }
}