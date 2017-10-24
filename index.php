<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
session_start();
require_once __DIR__ . '/autoload.php';

use App\Models\ExceptionM;
use App\Classes\View;


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathParts = explode('/', $path);


$ctrl = !empty($pathParts[1]) ? $pathParts[1] : 'servers';
$act = !empty($pathParts[2]) ? $pathParts[2] : 'all';
$id = !empty($pathParts[3]) ? $pathParts[3] : null;

// приводим строки к нужному нам виду, всё в нижний регистр, первый символ в верхний
$ctrl = ucfirst(mb_strtolower($ctrl));
$act = ucfirst(mb_strtolower($act));





$controllerClassName = 'App\\Controllers\\' . $ctrl;


try
{
    $controller = new $controllerClassName;
    $method = 'action' . $act;

    if(!empty($id))
    {
        $controller->$method($id);
    }else{
        $controller->$method();
    }
}
catch (ExceptionM $err)
{
    $view = new View();
    $view->error = $err->getMessage();
    $view->code = $err->getCode();
    switch($view->code){
        case 1:
            header('HTTP/1.1 404 Not Found');
            break;
        case 2:
            header('HTTP/1.1 403 Not Found');
            break;
    }
    $view->display('servers/error.php');
}
