<?php

namespace Sigec\controller;

use Sigec\view\Main as View;

class MainController extends ControllerBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $view = new View();
        $view->assign('username', $this->user->getName());
        $view->generateHTML();
    }
}
