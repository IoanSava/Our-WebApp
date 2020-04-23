<?php

class Controller {
    protected function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view) {
        require_once '../app/views/' . $view . '.html';
    }

    public function php_view($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }
}
?>
