<?php

namespace Sigec\controller;

use Sigec\view\Client as View;
use Core\helpers\Redirector;

class ClientController extends ControllerBase
{
    private $view = null;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
        $this->view->assign('action', '');
        $this->view->assign('username', $this->user->getName());
    }

    public function index()
    {
        $this->view->assign('clients', []);
        $this->view->generateHTML();
    }

    public function listAll()
    {
        $this->view->assign('clients', []);
        $this->view->generateHTML();
    }

    public function add($errors = [], $user = null)
    {
        $this->view->assign('errors', $errors);
        $this->view->assign('action', __FUNCTION__);
        $this->view->generateHTML();
    }

    public function update($errors = [], $user = null)
    {
        $this->view->assign('errors', $errors);
        $this->view->assign('action', __FUNCTION__);
        $this->view->generateHTML();
    }

    public function delete()
    {
        $this->view->generateHTML();
    }

    public function save()
    {
        $this->view->assign('clients', []);
        $this->view->generateHTML();
    }

    public function filter()
    {
        $this->view->assign('clients', []);
        $this->view->generateHTML();
    }
}
