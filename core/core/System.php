<?php

namespace Core\core;

class System
{
    private $action = null;
    private $controller = null;
    private $uri = null;
    private $defaultController = null;

    public function __construct($defaultController)
    {
        $this->setDefaultController($defaultController);
        $this->setUri();
        $this->processUri();
        $this->setEnvironment();
    }

    private function setEnvironment()
    {
        if (ENVIRONMENT == 'DEV') {
            ini_set('display_errors', 1);
            error_reporting(E_ALL | E_STRICT);
        } else {
            ini_set('display_errors', 0);
            error_reporting(false);
        }
    }

    private function setDefaultController($defaultController)
    {
        if (!isset($defaultController) || empty($defaultController)) {
            throw new \RuntimeException('Controller is not valid');
        }

        $this->defaultController = $defaultController;
    }

    private function setUri()
    {
        if (!isset($_SERVER["REQUEST_URI"])) {
            throw new \RuntimeException('Could not get uri from $_SERVER["REQUEST_URI"]');
        }

        $uri = $_SERVER["REQUEST_URI"];
        $uri = preg_replace('/^\/|\/index.php/', '', $uri);
        $this->uri = preg_replace('/\/+$/', '/', $uri);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }
    
    public function getController()
    {
        return $this->controller;
    }

    private function processUri()
    {
        $uri = explode('/', $this->uri);
        $count = count($uri);

        $this->controller
            = (isset($uri[0]) && !empty($uri[0])) ? $uri[0] : $this->defaultController;
        $this->action = isset($uri[1]) ? $uri[1] : 'index';

        for ($i = 2; $i < $count; $i++) {
            $key = $i;
            $value = ++$i;

            if (empty($uri[$key])) {
                continue;
            }

            $_GET[$uri[$key]] = isset($uri[$value]) ? $uri[$value] : '';
        }
    }

    public function run()
    {
        $class = CONTROLLERS_NAMESPACE . $this->controller . "Controller";
        if (class_exists($class)) {
            $controller = new $class();
        } else {
            die("Class {$this->controller} not exists.");
        }

        $action = $this->action;
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            die("There is no method {$action} at {$this->controller}.");
        }
    }
}
