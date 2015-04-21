<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Core\helpers\Session;
use Sigec\view\Login;
use Sigec\model\User;

class AuthController extends Controller
{
    private $view = null;
    private $session = null;
    private $mainUrl = "";
    private $pdo;

    public function __construct(\PDO $pdo = null)
    {
        $this->pdo = $pdo ?: new \PDO(
            'mysql:host='.DB_HOST.';dbname='.DB_BASE, 
            DB_USER, 
            DB_PASS
        );

        $this->session = new Session();
        $this->mainUrl = 'location: ' . URL_BASE . '/index.php/Main';
        $this->view = new Login();
    }

    public function index()
    {
        $this->view->assign('errors', array());
        $this->view->generateHTML();
    }

    public function login()
    {
        $this->isLogged();

        $user = new User($this->pdo);

        try {
            $user->retrieveByCredential($_POST['login'], $_POST['password']);
            $user->closePdo();
            $this->session->createSession('user', serialize($user));
            header($this->mainUrl);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->view->assign(
                'errors',
                array("Nao foi possivel consultar o usuario informado")
            );
            $this->view->generateHTML();
        }
    }

    public function logout($message = null)
    {
        $this->session->destroy();
        header('location: ' . URL_BASE);
    }

    public function isLogged()
    {
        if ($this->session->checkSession('user')) {
            header($this->mainUrl);
        }
    }
}
