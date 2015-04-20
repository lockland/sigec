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
        parent::__construct($pdo);
        $this->table = 'USUARIO';
    }

    public function setId($id)
    {
        $this->invalidId($id);
        $this->ID = $id;
        return $this;
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

    /**
     * Save this on database
     *
     * Try save user in database <br />
     * If an error occur a RuntimeException is thrown
     *
     * @return Integer $id Last id inserted
     * @throws \RuntimeException
     */
    public function save()
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (
                NOME, 
                LOGIN,
                SENHA,
                PERFIL_USUARIO
            ) VALUES (
                :NOME, 
                :LOGIN,
                :SENHA,
                :PERFIL_USUARIO
            );
        ");

        $stmt->bindParam(':NOME', $this->NOME, \PDO::PARAM_STR);
        $stmt->bindParam(':LOGIN', $this->LOGIN, \PDO::PARAM_STR);
        $stmt->bindParam(':SENHA', $this->SENHA, \PDO::PARAM_STR);
        $stmt->bindParam(':PERFIL_USUARIO', $this->PERFIL_USUARIO, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return (int) $this->pdo->lastInsertId();
        }

        throw new \RuntimeException('Fail to insert user');
    }

    /**
     * Delete a row in database
     *
     * @param Integer $id Row id to delete in database
     * @return Integer $rows Affected rows quantity
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE ID = :ID");
        $stmt->bindParam(':ID', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            return (int) $stmt->rowCount();
        }

        throw new \RuntimeException('Fail to delete user');
    }
    
    public function retrieve($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                *
            FROM 
                {$this->table}
            WHERE
                ID = :ID
        ");

        $stmt->bindParam(':ID', $id, \PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->mapper($stmt);
        }
        
        throw new \RuntimeException('Fail to retrieve user using id');
    
    }

    public function retrieveByCredential($login, $pass)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                *
            FROM 
                {$this->table}
            WHERE
                LOGIN = :LOGIN
                AND SENHA = :SENHA
        ");

        $stmt->bindParam(':LOGIN', $login, \PDO::PARAM_STR);
        $stmt->bindParam(':SENHA', $pass, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->mapper($stmt);
        }
        
        throw new \RuntimeException('Fail to retrieve user using credentials');
    }

    private function mapper($stmt)
    {
        $resultset = $stmt->fetch(\PDO::FETCH_OBJ);
        $stmt->closeCursor();

        var_dump($resultset);
        $this->setId((int) $resultset->ID);
        $this->setName($resultset->NOME);
        $this->setLogin($resultset->LOGIN);
        $this->setPassword($resultset->SENHA);
        $this->setProfile($resultset->PERFIL_USUARIO);

    }

    public function fetchAll()
    {
        $sql = "SELECT {$fields} FROM {$this->table} {$where} {$limit} {$offset}";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $resultset = $this->stmt->fetchAll();
    }
    public function update(){}
}
