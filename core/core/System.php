<?php

namespace Core\core;

class System
{
    private $action = null;
    private $controller = null;
    private $uri = null;

    public function __construct()
    {
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

    private function setUri()
    {
        if (isset($_SERVER["PATH_INFO"])) {
			$uri = $_SERVER["PATH_INFO"];
			$uri = preg_replace('/^\//', '', $uri);
			$this->uri = preg_replace('/\/+$/', '/', $uri);
		}
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
            = (isset($uri[0]) && !empty($uri[0])) ? $uri[0] : DEFAULT_CONTROLLER;
        $this->action = isset($uri[1]) ? $uri[1] : DEFAULT_ACTION;

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
