<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Core\helpers\Session;

class ControllerBase extends Controller
{
    protected $user = null;

    public function __construct()
    {
        $sm = new Session();

        if (!$sm->checkSession('user')) {
            @session_destroy();
            header('location: ' . URL_BASE);
            return;
        }

        $this->user = unserialize($sm->selectSession('user'));
    }

    public function index()
    {
    }
}
