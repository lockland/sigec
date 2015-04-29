<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Core\helpers\Session;
use Core\helpers\Redirector;

class ControllerBase extends Controller
{
    protected $user = null;

    public function __construct()
    {
        $session = new Session();
        $redirector = new Redirector(DEFAULT_CONTROLLER, DEFAULT_ACTION);

        if (!$session->checkSession('user')) {
            $session->destroy();
            $redirector->redirect();
        }

        $this->user = unserialize($session->selectSession('user'));
    }

    public function index()
    {
    }
}
