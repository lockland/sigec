<?php

namespace Sigec\model;

use Core\model\Model;

class Product extends Model
{

    private $ID = 0;
    private $DESC_PROD = "";
    private $ESTOQ_MIN = 0;
    private $ESTOQ_MAX = 0;
    private $VALOR_CUSTO = 0.0;
    private $VALOR_VENDA = 0.0;
    private $OBS = "";
    private $QTDE = 0;
    private $GRUPO = 1;
    private $FAMILIA = 1;
    private $LOCAL = 1;
    private $FORNECEDOR = 1;

    public function __construct(\PDO $pdo)
    {
        $this->setPdo($pdo);
        $this->table = 'PRODUTO';
    }

    public function getId()
    {
        return $this->ID;
    }

    public function setId($id)
    {
        $this->invalidId($id);
        $this->ID = $id;
        return $this;
    }

    public function getDescription()
    {
        return $this->DESC_PROD;
    }

    public function setDescription($description)
    {
        $this->DESC_PROD = $description;
        return $this;
    }

    public function getMinQuantity()
    {
        return (int) $this->ESTOQ_MIN;
    }

    public function setMinQuantity($minQuantity)
    {
        $this->ESTOQ_MIN = $minQuantity;
        return $this;
    }

    public function getMaxQuantity()
    {
        return (int) $this->ESTOQ_MAX;
    }

    public function setMaxQuantity($maxQuantity)
    {
        $this->ESTOQ_MAX = $maxQuantity;
        return $this;
    }

    public function getValue()
    {
        return $this->VALOR_CUSTO;
    }

    public function setValue($value)
    {
        $this->VALOR_CUSTO = $value;
        return $this;
    }

    public function getSalesValue()
    {
        return $this->VALOR_VENDA;
    }

    public function setSalesValue($salesValue)
    {
        $this->VALOR_VENDA = $salesValue;
        return $this;
    }

    public function getOBS()
    {
        return $this->OBS;
    }

    public function setOBS($OBS)
    {
        $this->OBS = $OBS;
        return $this;
    }

    public function getQuantity()
    {
        return $this->QTDE;
    }

    public function setQuantity($quantity)
    {
        $this->QTDE = $quantity;
        return $this;
    }

    public function getGroup()
    {
        return $this->GRUPO;
    }

    public function setGroup($group)
    {
        $this->GRUPO = $group;
        return $this;
    }

    public function getFamily()
    {
        return $this->FAMILIA;
    }

    public function setFamily($family)
    {
        $this->FAMILIA = $family;
        return $this;
    }

    public function getLocal()
    {
        return $this->LOCAL;
    }

    public function setLocal($local)
    {
        $this->LOCAL = $Local;
        return $this;
    }

    public function getSupply()
    {
        return $this->FORNECEDOR;
    }

    public function setSupply($supply)
    {
        $this->FORNECEDOR = $supply;
        return $this;
    }


    /**
     * Insert the product's information in database
     *
     * Try insert product in database <br />
     * If an error occur a RuntimeException is thrown
     *
     * @return Integer $id Last id inserted
     * @throws \RuntimeException
     */
    public function create()
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO {$this->table} (
                DESC_PROD,
                ESTOQ_MIN,
                ESTOQ_MAX,
                VALOR_CUSTO,
                VALOR_VENDA,
                OBS,
                QTDE,
                GRUPO_ID,
                FAMILIA_ID,
                LOCAL_ID,
                FORNECEDOR_ID
            ) VALUES (
                :DESC_PROD,
                :ESTOQ_MIN,
                :ESTOQ_MAX,
                :VALOR_CUSTO,
                :VALOR_VENDA,
                :OBS,
                :QTDE,
                :GRUPO_ID,
                :FAMILIA_ID,
                :LOCAL_ID,
                :FORNECEDOR_ID
            );
        ");

        $this->validateQuantities('Fail to insert product');

        @$stmt->bindParam(':DESC_PROD', $this->getDescription(), \PDO::PARAM_STR);
        @$stmt->bindParam(':ESTOQ_MIN', $this->getMinQuantity(), \PDO::PARAM_INT);
        @$stmt->bindParam(':ESTOQ_MAX', $this->getMaxQuantity(), \PDO::PARAM_INT);
        @$stmt->bindParam(':VALOR_CUSTO', $this->getValue(), \PDO::PARAM_STR);
        @$stmt->bindParam(':VALOR_VENDA', $this->getSalesValue(), \PDO::PARAM_STR);
        @$stmt->bindParam(':OBS', $this->getOBS(), \PDO::PARAM_STR);
        @$stmt->bindParam(':QTDE', $this->getQuantity(), \PDO::PARAM_STR);
        @$stmt->bindParam(':GRUPO_ID', $this->getGroup(), \PDO::PARAM_INT);
        @$stmt->bindParam(':FAMILIA_ID', $this->getFamily(), \PDO::PARAM_INT);
        @$stmt->bindParam(':LOCAL_ID', $this->getLocal(), \PDO::PARAM_INT);
        @$stmt->bindParam(':FORNECEDOR_ID', $this->getSupply(), \PDO::PARAM_INT);

        $stmt->execute();
        return (int) $this->pdo->lastInsertId();
    }

    public function validateQuantities($exceptionMsg)
    {
        if ($this->getMinQuantity() > $this->getMaxQuantity()) {
            throw new \RuntimeException($exceptionMsg);
        }

        if ($this->getMaxQuantity() < $this->getQuantity()) {
            throw new \RuntimeException($exceptionMsg);
        }
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
            throw new \RuntimeException('Fail to delete product');
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
        $this->DESC_PROD = $resultset->DESC_PROD;
        $this->ESTOQ_MIN = $resultset->ESTOQ_MIN;
        $this->ESTOQ_MAX = $resultset->ESTOQ_MAX;
        $this->VALOR_CUSTO = $resultset->VALOR_CUSTO;
        $this->VALOR_VENDA = $resultset->VALOR_VENDA;
        $this->OBS = $resultset->OBS;
        $this->QTDE = $resultset->QTDE;
        $this->GRUPO_ID = $resultset->GRUPO_ID;
        $this->FAMILIA_ID = $resultset->FAMILIA_ID;
        $this->LOCAL_ID = $resultset->LOCAL_ID;
        $this->FORNECEDOR_ID = $resultset->FORNECEDOR_ID;
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
