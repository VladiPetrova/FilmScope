<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . $class;
});

ini_set('mbstring.internal_encoding', 'UTF-8');
header('Content-Type: text/html; charset=UTF-8');

//Connection with db
\Model\Dao\DbConnection::getPdo();

$fileNotFound = false;

$controllerName = isset($_GET['target']) ? $_GET['target'] : 'base';
$methodName = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerClassName = '\\Controller\\' . ucfirst($controllerName) . 'Controller';

if (class_exists($controllerClassName)) {
    $contoller = new $controllerClassName();
    if (method_exists($contoller, $methodName)) {
        try {
            $contoller->$methodName();
        } catch (\PDOException $e) {
            header("HTTP/1.1 500");
            echo $e->getMessage();
            die();
        }
    } else {
        $fileNotFound = true;
    }
} else {
    $fileNotFound = true;
}


if ($fileNotFound) {
    require_once 'View/layouts/header.php';
    require_once 'View/errors/error_page.php';
    require_once 'View/errors/footer.php';
}


