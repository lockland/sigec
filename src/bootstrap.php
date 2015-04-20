<?php

date_default_timezone_set('America/Sao_Paulo');

define('ENVIRONMENT', 'DEV'); // Can be DEV or PROD;

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__ . DS . '..'));
define('CONTROLLERS_PATH', APP_ROOT . DS . 'src' . DS . 'controller');
define('CONTROLLERS_NAMESPACE', 'Sigec\\controller\\');
define('DEFAULT_CONTROLLER', 'Main');
define('DEFAULT_ACTION', 'index');
define('URL_BASE', '/sigec');
define('PUBLIC_URL', URL_BASE . '/public');

// Database Configuration 
define('BD_HOST', 'localhost');
define('BD_USER', 'root');
define('BD_PASS', '');
define('BD_BASE', 'sigec');

require_once APP_ROOT . DS . 'vendor' . DS . 'autoload.php';
