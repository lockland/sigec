<?php

date_default_timezone_set('America/Sao_Paulo');

define('ENVIRONMENT', 'DEV'); // Can be DEV or PROD;

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__ . DS . '..'));
define('CONTROLLERS_PATH', APP_ROOT . DS . 'src' . DS . 'controller');
define('CONTROLLERS_NAMESPACE', 'Sigec\\controller\\');
define('DEFAULT_CONTROLLER', 'Auth');
define('DEFAULT_ACTION', 'index');
define('URL_BASE', '/sigec');
define('PUBLIC_URL', URL_BASE . '/public');

// Database Configuration 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_BASE', 'sigec');

require_once APP_ROOT . DS . 'vendor' . DS . 'autoload.php';
