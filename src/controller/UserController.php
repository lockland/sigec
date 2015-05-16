<?php

namespace Sigec\controller;

use Sigec\view\User as View;
use Core\helpers\Redirector;

class UserController extends ControllerBase
{
    private $view = null;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
        $this->view->assign('action', '');
        $this->view->assign('controller', 'User');
        $this->view->assign('username', $this->user->getName());
        $this->user->setPdo(new \PDO(DB_DSN, DB_USER, DB_PASS));
    }

    public function listAll()
    {
        $this->view->assign('users', $this->user->fetchAll());
        $this->view->generateHTML();
    }

    public function add($errors = [], $user = null)
    {
        $this->view->assign('errors', $errors);
        $this->view->assign('user', $user);
        $this->view->assign('action', 'add');
        $this->view->assign('title', 'Cadastrar');
        $this->view->generateHTML();

    }

    public function update($errors = [], $user = null)
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user = $user ?: new \StdClass();

        try {
            $this->user->retrieve($id);
            $user->id = $this->user->getId();
            $user->name = $this->user->getName();
            $user->login = $this->user->getLogin();
            $user->profile = $this->user->getProfile();
            $user->isEnable = $this->user->isEnable();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Could not retrieve user using id';
        }

        $this->view->assign('errors', $errors);
        $this->view->assign('user', $user);
        $this->view->assign('action', 'update');
        $this->view->assign('title', 'Editar');
        $this->view->generateHTML();

    }

    public function save()
    {
        $errors = [];
        $post = (object) $_POST;

        if ($post->password != $post->rpassword) {
            $errors[] = "Password don't match";
        }

        try {
            $this->user->setId((int) $post->id);
            $this->user->setName($post->name);
            $this->user->setLogin($post->login);
            $this->user->setPassword($post->password);
            $this->user->setProfile($post->profile);
            $this->user->setEnable(
                (isset($post->status) && $post->status == 1)
            );
            $this->user->save();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Could not store the user in database';
        }

        $action = $_GET['action'];
        
        if (count($errors) <= 0) {
            $redirector = new Redirector('User', 'listAll');
            $redirector->redirect();
        }

        $this->$action($errors, $post);
    }

    public function filter()
    {
        $this->view->assign('users', $this->user->filter($_POST['field']));
        $this->view->generateHTML();
    }
}
