<?php

namespace Core\helpers;

/**
 * Helper to manage sessions
 * @link http://www.videoaulasbrasil.com.br/criando-um-mini-framework-php-5-com-mvc-parte-7/ 
 */
class Session
{
    public function createSession($name, $value)
    {
        $_SESSION[$name] = $value;
        return $this;
    }
    public function selectSession($name)
    {
        return $_SESSION[$name];
    }

    public function deleteSession($name)
    {
        unset($_SESSION[$name]);
        return $this;
    }

    public function checkSession($name)
    {
        return isset($_SESSION[$name]);
    }    
}
