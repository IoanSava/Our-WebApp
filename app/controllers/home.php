<?php

class Home extends Controller
{
    public function index($page = 'index')
    {
        if (!file_exists('../app/views/' . $page . '.html')) {
            $this->view('404');
        }
        else{
            $this->view($page);
        }
    }
}
