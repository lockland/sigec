<?php

@session_start;

require_once 'src/bootstrap.php';

$system = new Core\core\System('Login');
$system->run();
