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
    private $ATIVO = true;

    public function __construct(\PDO $pdo)
    {
        $this->setPdo($pdo);
        $this->table = 'USUARIO';
    }

    public function setId($id)
    {
        $this->invalidId($id);
        $this->ID = $id;
        return $this;
    }

    public function setEnable($enable = true)
    {
        $this->invalidBoolean($enable, 'Enable');
        $this->ATIVO = $enable;
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
        $this->SENHA = md5($password);
        return $this;
    }

    public function setProfile($profile)
    {
        $this->invalidStringArgument($profile, 'Profile');
        $this->PERFIL_USUARIO = $profile;
        return $this;
    }

    public function isEnable()
    {
        return !!$this->ATIVO;
    }

    public function getId()
    {
        return $this->ID;
    }

    public function getName()
    {
        return $this->NOME;
    }

    public function getLogin()
    {
        return $this->LOGIN;
    }

    public function getPassword()
    {
        return $this->SENHA;
    }

    public function getProfile()
    {
        return $this->PERFIL_USUARIO;
    }

    /**
     * Insert the user's information in database
     *
     * Try insert user in database <br />
     * If an error occur a RuntimeException is thrown
     *
     * @return Integer $id Last id inserted
     * @throws \RuntimeException
     */
    public function create()
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

        if (!$stmt->execute()) {
            throw new \RuntimeException('Fail to insert user');
        }

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * Delete a row in database
     *
     * @param  Integer $id Row id to delete in database
     * @return Integer $rows Affected rows quantity
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE ID = :ID");
        $stmt->bindParam(':ID', $id, \PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new \RuntimeException('Fail to delete user');
        }

        return  (int) $stmt->rowCount();
    }
    
    public function retrieve($id)
    {
        $this->invalidId($id);

        $stmt = $this->pdo->prepare("
            SELECT 
                *
            FROM 
                {$this->table}
            WHERE
                ID = :ID
        ");

        $stmt->bindParam(':ID', $id, \PDO::PARAM_INT);

        $this->validateAndMapper($stmt, 'Fail to retrieve user using id');
    }

    public function retrieveByCredential()
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

        $stmt->bindParam(':LOGIN', $this->LOGIN, \PDO::PARAM_STR);
        $stmt->bindParam(':SENHA', $this->SENHA, \PDO::PARAM_STR);

        $this->validateAndMapper($stmt, 'Fail to retrieve user using credential');

    }

    private function validateAndMapper($stmt, $errorMsg)
    {
        if (!$stmt->execute()) {
            throw new \RuntimeException($errorMsg);
        }

        $resultset = $stmt->fetch(\PDO::FETCH_OBJ);

        if (!$resultset) {
            throw new \RuntimeException($errorMsg);
        }

        $stmt->closeCursor();
        $this->mapper($resultset);
    }

    private function mapper($resultset)
    {
        $this->ID = $resultset->ID;
        $this->NOME = $resultset->NOME;
        $this->LOGIN = $resultset->LOGIN;
        $this->SENHA = $resultset->SENHA;
        $this->PERFIL_USUARIO = $resultset->PERFIL_USUARIO;
        $this->ATIVO = !!$resultset->ATIVO;
    }

    public function fetchAll()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        $resultset = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $stmt->closeCursor();
        return $resultset;
    }

    public function update()
    {
        $stmt = $this->pdo->prepare("
            UPDATE {$this->table}
            SET NOME = :NOME, LOGIN = :LOGIN, SENHA = :SENHA, PERFIL_USUARIO = :PERFIL_USUARIO, ATIVO = :ATIVO
            WHERE ID = :ID
        ");

        $stmt->bindParam(':ID', $this->ID, \PDO::PARAM_INT);
        $stmt->bindParam(':NOME', $this->NOME, \PDO::PARAM_STR);
        $stmt->bindParam(':LOGIN', $this->LOGIN, \PDO::PARAM_STR);
        $stmt->bindParam(':SENHA', $this->SENHA, \PDO::PARAM_STR);
        $stmt->bindParam(':PERFIL_USUARIO', $this->PERFIL_USUARIO, \PDO::PARAM_STR);
        $stmt->bindParam(':ATIVO', $this->ATIVO, \PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new \RuntimeException('Fail to update user');
        }

        return (int) $stmt->rowCount();
    }
}
