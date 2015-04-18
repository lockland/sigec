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
     * @return Integer $id Last id inserted
     */
    public function save(Array $fields)
    {
        $columns = array_keys($fields);

        $prepareString = function ($v) {
            for ($i = 0; $i < count($v); $i++) {
                $v[$i] = ":" . $v[$i];
            }
            return $v;
        };

        $prepareKeys = $prepareString($columns);
        $columns = implode(', ', $columns);
        $values = array_values($fields);
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

    /**
     * Delete a row in database
     *
     * @param Integer $id Row id to delete in database
     * @return Integer $rows Affected rows quantity
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE ID = :ID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ID', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
