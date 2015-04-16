<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Sigec\view\Main;

class MainController extends Controller
{
    public function index()
    {
        $view = new Main();
        $view->assign('username', 'Francielle Vareira');
        $view->generateHTML();
    }
}
