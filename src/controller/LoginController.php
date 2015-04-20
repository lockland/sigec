<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Sigec\view\Login;
use Sigec\model\User;

class LoginController extends Controller
{
    private $view = null;

    public function __construct()
    {
        $this->view = new Login();
    }

    public function index()
    {
        $this->view->assign('errors', Array());
        $this->view->generateHTML();
    }

    public function login() 
    {
        $pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_BASE,DB_USER,DB_PASS);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $user = new User($pdo);
        try {
            $user->retrieveByCredential($_POST['login'], $_POST['password']);
            var_dump($user);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->view->assign(
                'errors', 
                Array("Nao foi possivel consultar o usuario informado")
            );
            $this->view->generateHTML();
        }
    }

    public function logout($message = null)
    {
        print $message;
    }
}
