<?php

session_start();

require_once __DIR__ . '/../config/Env.php';
Env::load();
require_once __DIR__ . '/../config/helpers.php';

if ($_ENV['APP_DEBUG'] ?? false) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../controllers/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$url = $_GET['url'] ?? 'auth/login';
$parts = explode('/', trim($url, '/'));

$controllerName = ucfirst($parts[0] ?? 'auth') . 'Controller';
$methodName = $parts[1] ?? 'login';

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        http_response_code(404);
        echo "Method not found: $methodName";
    }
} else {
    http_response_code(404);
    echo "Controller not found: $controllerName";
}
