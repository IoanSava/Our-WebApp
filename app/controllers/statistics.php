<?php

class Statistics extends Controller
{
    public function index($page)
    {
        if (strcmp($page, "geochart") == 0) {
            $years = $this->model('Popup')->getListOfYears();
            $this->php_view($page, $years);
        } else {
            $states = $this->model('Popup')->getListOfStates();
            $this->php_view($page, $states);
        }
    }
}
