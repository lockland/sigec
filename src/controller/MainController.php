<?php

namespace Sigec\controller;

use Sigec\view\Main;

class MainController extends ControllerBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $view = new Main();
        $view->assign('username', 'Francielle Vareira');
        $view->generateHTML();
    }
}
