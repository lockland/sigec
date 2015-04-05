<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('America/Sao_Paulo');
define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__));

require_once APP_ROOT . DS . 'vendor' . DS . 'autoload.php';
use Sigec\controller\LoginController;

if (isset($_GET["c"]) == false) {
	$l = new LoginController();
	print $l->logout();
	die();
}

$file = $_GET["c"] . "Controller.php";
$controller_path = APP_ROOT . DS . 'src' . DS . 'controller';
if (file_exists($controller_path . DS . $file) == false) {
	$l = new LoginController();
	print $l->logout("File {$file} not exists.");
	die();
}	

$class = "Sigec\\controller\\" . $_GET["c"] . "Controller";
if (class_exists($class) == true) {
	$controller = new $class();
} else {
	$l = new LoginController();
	print $l->logout("Class {$class} not exists.");
	die();
}

$method = isset($_GET["m"]) ? $_GET["m"] : "generateHTML";
if(method_exists($controller, $method) == true){
	print $controller->{$method}();
} else {
	$l = new LoginController();
	print $l->logout("There is no method {$method} at {$class}.");
	die();
}
