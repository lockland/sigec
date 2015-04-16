<?php

date_default_timezone_set('America/Sao_Paulo');

define('ENVIRONMENT', 'DEV'); // Can be DEV or PROD;

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__ . DS . '..'));
define('CONTROLLERS_PATH', APP_ROOT . DS . 'src' . DS . 'controller');
define('CONTROLLERS_NAMESPACE', 'Sigec\\controller\\');

// Database Configuration 
define('BD_HOST', 'localhost');
define('BD_USUARIO', 'root');
define('BD_SENHA', '');
define('BD_NOME', 'sigec');

require_once APP_ROOT . DS . 'vendor' . DS . 'autoload.php';

