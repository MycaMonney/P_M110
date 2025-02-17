<?php

namespace Models;

use Models\PDOSingleton;
use Interfaces\IActiveRecord;
use PDO;

class ARRegions extends ActiveRecord implements IActiveRecord
{
    protected static $table = 'regions';

    public $id = null;
    public $name = '';

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public  function getId()
    {
        return $this->id;
    }

    public function create()
    {
        $sql = "INSERT INTO " . static::$table . " (name) VALUES (:name);";
        $this->executeQuery($sql, [
            'name' => $this->name
        ]);
        $this->id = $this->pdoConnection->lastInsertId();
    }    
    
    public function update()
    {
        $sql = "UPDATE " . static::$table . " SET name = :name WHERE id = :id;";
        $this->executeQuery($sql, [
            'name' => $this->name,
            'id' => $this->id
        ]);
    }

    public function delete()
    {
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
        $this->executeQuery($sql, ['id' => $this->id]);
    }
}
