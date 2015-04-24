<?php

namespace Core\model;

abstract class Model
{
    /**
     * Php Data Object
     *
     * @var \PDO $pdo
     */
    protected $pdo = null;
    
    public function setPdo(\PDO $pdo)
    {
        if (!is_object($pdo)) {
            throw new \InvalidArgumentException('PDO is invalid');
        }
        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function closePdo()
    {
        $this->pdo = null;
    }

    protected function invalidStringArgument($attr, $attrDescription)
    {
        if (is_null($attr) || !is_string($attr) || empty($attr)) {
            throw new \InvalidArgumentException("{$attrDescription} is invalid!");
        }
    }

    protected function invalidId($id)
    {
        if (is_null($id) || !is_int($id)) {
            throw new \InvalidArgumentException("ID is invalid!");
        }
    }

    protected function invalidBoolean($bool, $boolDescription)
    {
        if (!is_bool($bool)) {
            throw new \InvalidArgumentException("{$boolDescription} is invalid!");
        }
    }

    public function save()
    {
        if ($this->getId() == 0) {
            return $this->create();
        }
        
        return $this->update();
    }

    abstract public function getId();
    abstract public function create();
    abstract public function delete($id);
    abstract public function fetchAll();
    abstract public function retrieve($id);
    abstract public function update();
}
