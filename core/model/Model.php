<?php

namespace Core\model;

abstract class Model
{
    /**
     * Php Data Object
     *
     * @var \PDO $pdo
     */
    protected $pdo;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
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

    abstract public function save();
    abstract public function delete($id);
    abstract public function fetchAll();
    abstract public function retrieve($id);
    abstract public function update();
}
