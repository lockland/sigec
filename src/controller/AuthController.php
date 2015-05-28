<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Core\helpers\Session;
use Core\helpers\Redirector;
use Sigec\view\Login;
use Sigec\model\User;

class AuthController extends Controller
{
    private $view = null;
    private $session = null;
    private $redirector = null;
    private $pdo;

    public function __construct(\PDO $pdo = null)
    {
        $this->pdo = $pdo ?: new \PDO(
            DB_DSN,
            DB_USER,
            DB_PASS
        );

        $this->session = new Session();
        $this->redirector = new Redirector('Main', DEFAULT_ACTION);
        $this->view = new Login();
    }

    public function index()
    {
        $this->view->assign('errors', []);
        $this->view->generateHTML();
    }

    public function login()
    {
        $this->ifIsLoggedRedirectToMain();

        $user = new User($this->pdo);

        try {
            $user->setLogin($_POST['login']);
            $user->setPassword($_POST['password']);
            $user->retrieveByCredential();
            $user->closePdo();
            $this->authenticate($user);
            $this->redirector->redirect();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->view->assign(
                'errors',
                ["Nao foi possivel consultar o usuario informado"]
            );
            $this->view->generateHTML();
        }
    }

    private function authenticate($user)
    {
        if (!$user->isEnable()) {
            throw new \RuntimeException('User [' . $user->getLogin() . '] is disabled');
        }

        $this->session->createSession('user', serialize($user));
    }

    public function logout()
    {
        $this->session->destroy();
        $this->redirector->redirect();
    }

    private function ifIsLoggedRedirectToMain()
    {
        if ($this->session->checkSession('user')) {
            $this->redirector->redirect();
        }
    }
}
