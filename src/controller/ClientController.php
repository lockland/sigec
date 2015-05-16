<?php

namespace Sigec\controller;

use Sigec\view\Client as View;
use Core\helpers\Redirector;
use Sigec\model\Client;

class ClientController extends ControllerBase
{
    private $view = null;
    private $model = null;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
        $this->view->assign('action', '');
        $this->view->assign('controller', 'Client');
        $this->view->assign('username', $this->user->getName());
        $this->client = new Client(new \PDO(DB_DSN, DB_USER, DB_PASS));
    }

    public function listAll()
    {
        $this->view->assign('clients', $this->client->fetchAll());
        $this->view->generateHTML();
    }

    public function add($errors = [], $client = null)
    {
        $this->view->assign('errors', $errors);
        $this->view->assign('client', $client);
        $this->view->assign('action', __FUNCTION__);
        $this->view->generateHTML();
    }

    public function update($errors = [], $client = null)
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $client = $client ?: new \StdClass();

        try {
            $this->client->retrieve($id);
            $client->id = $this->client->getId();
            $client->name = $this->client->getName();
            $client->motherName = $this->client->getMotherName();
            $client->address = $this->client->getAddress();
            $client->phone = $this->client->getPhone();
            $client->cpfOrCnpj = $this->client->getCpfOrCnpj();
            $client->email = $this->client->getEmail();
            $client->city = $this->client->getCity();
            $client->state = $this->client->getState();
            $client->district = $this->client->getDistrict();

        } catch (\Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Could not retrieve client using id';
        }

        $this->view->assign('errors', $errors);
        $this->view->assign('client',$client);
        $this->view->assign('action', __FUNCTION__);
        $this->view->generateHTML();
    }

    public function save()
    {
        $errors = [];
        $post = (object) $_POST;

        try {
            $this->client->setId((int) $post->id);
            $this->client->setName($post->name);
            $this->client->setMotherName($post->motherName);
            $this->client->setAddress($post->address);
            $this->client->setPhone($post->phone);
            $this->client->setCpfOrCnpj($post->cpfOrCnpj);
            $this->client->setEmail($post->email);
            $this->client->setCity($post->city);
            $this->client->setState($post->state);
            $this->client->setDistrict($post->district);
            $this->client->save();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Could not store the client in database';
        }

        $action = $_GET['action'];
        
        if (count($errors) <= 0) {
            $redirector = new Redirector('Client', 'listAll');
            $redirector->redirect();
        }

        $this->$action($errors, $post);
    }

    public function filter()
    {
        $this->view->assign('clients', []);
        $this->view->generateHTML();
    }
}
