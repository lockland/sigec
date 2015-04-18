<?php

namespace Sigec\model;

use Core\model\Model;

class User extends Model
{

    private $ID = 0;
    private $NOME;
    private $LOGIN;
    private $SENHA;
    private $PERFIL_USUARIO;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->table = 'USUARIO';
    }

    public function setName($name)
    {
        $this->invalidStringArgument($name, 'Name');
        $this->NOME = $name;
        return $this;
    }

    public function setLogin($login)
    {
        $this->invalidStringArgument($login, 'Login');
        $this->LOGIN = $login;
        return $this;
    }

    public function setPassword($password)
    {
        $this->invalidStringArgument($password, 'Password');
        $this->SENHA = $password;
        return $this;
    }

    public function setProfile($profile)
    {
        $this->invalidStringArgument($profile, 'Profile');
        $this->PERFIL_USUARIO = $profile;
        return $this;
    }

    public function save(Array $fields = null)
    {
        if (is_null($fields)) {
            $fields = get_object_vars($this);
            unset($fields['ID']);
            unset($fields['pdo']);
            unset($fields['table']);
        }
        
        return parent::save($fields);
    }
}
