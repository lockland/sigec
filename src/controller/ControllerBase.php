<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Core\helpers\Session;

class ControllerBase extends Controller
{
    protected $user = null;

    public function __construct()
    {
        $session = new Session();

        if (!$session->checkSession('user')) {
            $session->destroy();
            header('location: ' . URL_BASE);
        } else {
            $this->user = unserialize($session->selectSession('user'));
        }
    }

    public function index()
    {
    }
}
