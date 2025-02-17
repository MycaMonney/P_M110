<?php

namespace Models;

use PDO;

abstract class BaseModel
{
    protected $pdoConnection;
    
    protected static $table;

    public function __construct()
    {
        $pdo = PDOSingleton::getInstance();
        $this->pdoConnection = $pdo->getConnection();
    }

    protected function executeQuery($sql, $params = [])
    {
        $stmt = $this->pdoConnection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function read() {
        $pdo = PDOSingleton::getInstance();
        $table = static::$table;        
        // Préparation de la requête pour récupérer tous les enregistrements
        $stmt = $pdo->getConnection()->query("SELECT * FROM $table");
        $datas = $stmt->fetchAll();
        $result = [];
        foreach ($datas as $row) {
            $result[] = new static(...array_values($row)); // Utilise `new static` pour créer une instance de la classe enfant
        }
        return $result;
    }

    /**
     * 
     */
    public function toString()
    {
        $properties = get_object_vars($this); // Récupère les propriétés de l'objet courant
        $output = [];
        foreach ($properties as $name => $value) {
            if (is_object($value)) {
                continue; // Ignore les propriétés qui sont des objets
            }
            $output[] = "[$name : $value]";
        }
        return sprintf(
            "** %s ** : %s",
            get_class($this),
            implode(' ', $output)
        );
    }
}
