<?php

require_once 'src/bootstrap.php';

use Sigec\controller\LoginController;

if (isset($_GET["c"]) == false) {
	$l = new LoginController();
	$l->logout('Invalid Action');
	die();
}

$file = $_GET["c"] . "Controller.php";
$controller_path = APP_ROOT . DS . 'src' . DS . 'controller';
if (file_exists($controller_path . DS . $file) == false) {
	$l = new LoginController();
	$l->logout("File {$file} not exists.");
	die();
}	

$class = "Sigec\\controller\\" . $_GET["c"] . "Controller";
if (class_exists($class) == true) {
	$controller = new $class();
} else {
	$l = new LoginController();
	$l->logout("Class {$class} not exists.");
	die();
}

$method = isset($_GET["m"]) ? $_GET["m"] : "index";
if(method_exists($controller, $method) == true){
	$controller->$method();
} else {
	$l = new LoginController();
	$l->logout("There is no method {$method} at {$class}.");
	die();
}
