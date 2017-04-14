<?php
session_start();
function __autoload($className)
{
    $path = dirname(__DIR__) . '/controllers/' . $className . '.php';
    if(is_file($path))
        require_once $path;
    elseif(is_file($path = dirname(__DIR__).'/app/'.$className.'.php')){
        require_once $path;
    }
    else{ header("Location: http://" . $_SERVER['HTTP_HOST'] . "/Errors");}
}
ini_set('display_errors',1);
error_reporting(E_ALL);
include"controllers/RunProject.php";