<?php

namespace Core\model;

/**
 * This class implement crud methods
 */
abstract class Model
{
    /**
     * Php Data Object
     *
     * @var \PDO $pdo
     */
    protected $pdo;
    
    protected $table;

    protected function invalidStringArgument($attr, $attrDescription)
    {
        if (is_null($attr) && !is_string($attr) && empty($attr)) {
            throw new \InvalidArgumentException("{$attrDescription} is not valid!");
        }
    }

    /**
     * Save this on database
     *
     * @return $this
     */
    public function create(Array $fields)
    {
        $columns = array_keys($fields);

        $prepare = function ($v) {
            for ($i = 0; $i < count($v); $i++) {
                $v[$i] = ":" . $v[$i];
            }

            return $v;
        };

        $prepareKeys = $prepare($columns);
        $columns = implode(', ', $columns);

        $values = array_values($fields);

        $id = 0;
        $values[$id] = null; //The id need is null due autoincrement

        $values = array_combine($prepareKeys, $values);
        $prepareKeys = implode(', ', $prepareKeys);

        $sql = "
            INSERT INTO {$this->table} 
            ({$columns}) VALUES ({$prepareKeys});
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        
        return $this->pdo->lastInsertId();

    }
}
