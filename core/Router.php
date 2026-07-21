<?php
    class Router {
        private array $routes = [];

        public function get($url, $action) {
            $this->routes['GET'][$url] = $action;
        }

        public function post($url, $action) {
            $this->routes['POST'][$url] = $action;
        }

        public function dispatch($url, $method) {
            if(!isset($this->routes[$method][$url])) {
                http_response_code(404);
                die("404");
            }

            [$controller, $function] = $this->routes[$method][$url];
            require_once __DIR__ . "/../controllers/$controller.php";
            $controller = new $controller();
            $controller->$function();
        }
    }
?>