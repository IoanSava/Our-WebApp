<?php

class Home extends Controller {
    public function index($page = 'index.html') {
        $this->view($page);
    }
}
?>