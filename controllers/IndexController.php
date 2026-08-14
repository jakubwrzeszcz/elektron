<?php
    require_once "config.php";

    class IndexController {
        public function index() {
            require __DIR__ . '/../views/index.php';
        }
    }

?>