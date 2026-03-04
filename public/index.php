<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../../app/controllers/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$url = $_GET['url'] ?? 'home'; 
$urlParts = explode('/', rtrim($url, '/'));

$controllerName = ucfirst($urlParts[0]) . 'Controller'; 
$methodName = $urlParts[1] ?? 'index';

echo "--- System Check ---<br>";
echo "Looking for Controller: <b>$controllerName</b><br>";
echo "Looking for Method: <b>$methodName</b><br>";
echo "--------------------<br><br>";

if (class_exists($controllerName)) {
    $controller = new $controllerName();
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        echo "Error: Method '$methodName' not found in '$controllerName'.";
    }
} 
else {
    echo "Error: File 'controllers/$controllerName.php' does not exist or class is named incorrectly.";
}