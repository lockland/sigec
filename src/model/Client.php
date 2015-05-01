<?php

namespace Sigec\model;

use Core\model\Model;

class Client extends Model
{
    private $ID = 0;
    private $NOME;
    private $NOME_MAE;
    private $END;
    private $TEL;
    private $CPF_CNPJ;
    private $EMAIL;
    private $CIDADE;
    private $ESTADO;
    private $BAIRRO;


    public function __construct(\PDO $pdo)
    {
        $this->setPdo($pdo);
        $this->table = 'CLIENTE';
    }

    public function setId($id)
    {
        $this->invalidId($id);
        $this->ID = $id;
        return $this;
    }

    public function getId()
    {
        return $this->ID;
    }

    public function setName($name)
    {
        $this->invalidStringArgument($name, 'Name');
        $this->NOME = $name;
        return $this;
    }

    public function getName()
    {
        return $this->NOME;
    }
    
    public function setMothersName($mothersName)
    {
        $this->invalidStringArgument($mothersName, "Mother's name");
        $this->NOME_MAE = $mothersName;
        return $this;
    }

    public function getMotherName()
    {
        return $this->NOME_MAE;
    }

    public function setAddress($address)
    {
        $this->invalidStringArgument($address, 'Address');
        $this->END = $address;
        return $this;
    }

    public function getAddress()
    {
        return $this->END;
    }

    public function setPhone($phone)
    {
        $this->invalidStringArgument($phone, 'Phone');
        $this->TEL = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->TEL;
    }

    public function setCfpOrCnpj($cpfOrCnpj)
    {
        $this->invalidStringArgument($cpfOrCnpj, 'CPF or CNPJ');
        $this->CPF_CNPJ = $cpfOrCnpj;
        return $this;
    }

    public function getCfpOrCnpj()
    {
        return $this->CPF_CNPJ;
    }

    public function setEmail($email)
    {
        $this->invalidStringArgument($email, 'E-mail');
        $this->EMAIL = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->EMAIL;
    }

    public function setCity($city)
    {
        $this->invalidStringArgument($city, 'City');
        $this->CIDADE = $city;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setState($state)
    {
        $this->invalidStringArgument($state, 'State');
        $this->ESTADO = $state;
        return $this;
    }

    public function getState()
    {
        return $this->ESTADO;
    }

    public function setDistrict($district)
    {
        $this->invalidStringArgument($district, 'District');
        $this->BAIRRO = $district;
        return $this;
    }

    public function getDistrict()
    {
        return $this->BAIRRO;
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
                NOME_MAE,
                END,
                TEL,
                CPF_CNPJ,
                EMAIL,
                CIDADE,
                ESTADO,
                BAIRRO
            ) VALUES (
                :NOME,
                :NOME_MAE,
                :END,
                :TEL,
                :CPF_CNPJ,
                :EMAIL,
                :CIDADE,
                :ESTADO,
                :BAIRRO
            );
        ");

        $stmt->bindParam(':NOME', $this->NOME, \PDO::PARAM_STR);
        $stmt->bindParam(':NOME_MAE', $this->NOME_MAE, \PDO::PARAM_STR);
        $stmt->bindParam(':END', $this->END, \PDO::PARAM_STR);
        $stmt->bindParam(':TEL', $this->TEL, \PDO::PARAM_STR);
        $stmt->bindParam(':CPF_CNPJ', $this->CPF_CNPJ, \PDO::PARAM_STR);
        $stmt->bindParam(':EMAIL', $this->EMAIL, \PDO::PARAM_STR);
        $stmt->bindParam(':CIDADE', $this->CIDADE, \PDO::PARAM_STR);
        $stmt->bindParam(':ESTADO', $this->ESTADO, \PDO::PARAM_STR);
        $stmt->bindParam(':BAIRRO', $this->BAIRRO, \PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \RuntimeException('Fail to insert client');
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
            throw new \RuntimeException('Fail to delete client');
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

        $this->validateAndMapper($stmt, 'Fail to retrieve client using id');
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
        $this->NOME_MAE = $resultset->NOME_MAE;
        $this->END = $resultset->END;
        $this->TEL = $resultset->TEL;
        $this->CPF_CNPJ = $resultset->CPF_CNPJ;
        $this->EMAIL = $resultset->EMAIL;
        $this->CIDADE = $resultset->CIDADE;
        $this->ESTADO = $resultset->ESTADO;
        $this->BAIRRO = $resultset->BAIRRO;
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
            SET 
                NOME = :NOME,
                NOME_MAE = :NOME_MAE,
                END = :END,
                TEL = :TEL,
                CPF_CNPJ = :CPF_CNPJ,
                EMAIL = :EMAIL,
                CIDADE = :CIDADE,
                ESTADO = :ESTADO,
                BAIRRO = :BAIRRO
            WHERE ID = :ID
        ");

        $stmt->bindParam(':ID', $this->ID, \PDO::PARAM_INT);
        $stmt->bindParam(':NOME', $this->NOME, \PDO::PARAM_STR);
        $stmt->bindParam(':NOME_MAE', $this->NOME_MAE, \PDO::PARAM_STR);
        $stmt->bindParam(':END', $this->END, \PDO::PARAM_STR);
        $stmt->bindParam(':TEL', $this->TEL, \PDO::PARAM_STR);
        $stmt->bindParam(':CPF_CNPJ', $this->CPF_CNPJ, \PDO::PARAM_STR);
        $stmt->bindParam(':EMAIL', $this->EMAIL, \PDO::PARAM_STR);
        $stmt->bindParam(':CIDADE', $this->CIDADE, \PDO::PARAM_STR);
        $stmt->bindParam(':ESTADO', $this->ESTADO, \PDO::PARAM_STR);
        $stmt->bindParam(':BAIRRO', $this->BAIRRO, \PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new \RuntimeException('Fail to update client');
        }

        return (int) $stmt->rowCount();
    }

    public function filter($field)
    {
        $this->invalidStringArgument($field, 'Filter field');

        $field = "%{$field}%";
        $stmt = $this->pdo->prepare("
            SELECT 
                * 
            FROM 
                {$this->table} 
            WHERE 
                1=1 
                AND ID LIKE :FIELD 
                OR NOME LIKE :FIELD 
        ");

        $stmt->bindParam(':FIELD', $field, \PDO::PARAM_STR);
        
        if (!$stmt->execute()) {
            throw new \RuntimeException('Fail to filter clients');
        }

        $resultset = $stmt->fetchAll(\PDO::FETCH_OBJ);
        $stmt->closeCursor();
        return $resultset;
    }
}
