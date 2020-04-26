<?php

class Home extends Controller
{
    public function index($page = 'index')
    {
        $this->view($page);
    }
}
