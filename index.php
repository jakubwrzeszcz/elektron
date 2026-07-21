<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'core/Router.php';
    $router = new Router();
    require_once 'core/routes.php';

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', trim($uri, '/'));
    array_shift($uri);
    $url = '/' . implode('/', $uri);

    if($url === '/') {
        $url = '/';
    }

    $router->dispatch($url, $_SERVER['REQUEST_METHOD']);
?>