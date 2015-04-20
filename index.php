<?php

@session_start();

require_once 'src/bootstrap.php';

if (!preg_match('/index\.php/', $_SERVER['REQUEST_URI'])) {
    header('location: index.php');
}

$system = new Core\core\System();
$system->run();
