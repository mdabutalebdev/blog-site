<?php

define('APP_ROOT', dirname(__DIR__));

// Simple autoloader
spl_autoload_register(function ($class) {
    // Convert namespace to full file path
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = APP_ROOT . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load helpers
require_once APP_ROOT . '/app/Helpers/functions.php';

session_start();

use app\Core\Router;
use app\Core\Request;
use app\Core\Response;

$router = new Router();

// Load routes
require_once APP_ROOT . '/config/routes.php';

$request = new Request();
$response = new Response();

$router->dispatch($request, $response);
