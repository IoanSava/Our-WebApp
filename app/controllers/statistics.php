<?php

class Statistics extends Controller
{
    public function index($page)
    {
        $states = $this->model('Popup')->getListOfStates();
        $this->php_view($page, $states);
    }
}
