<?php

namespace Models;

use Models\PDOSingleton;
use Interfaces\IActiveRecord;
use PDO;

class ARUsers extends ActiveRecord implements IActiveRecord
{
    protected static $table = 'users';

    public ?int $id = null;
    public string $username = '';
    public ?string $password = null;
    public int $score = 0;
    public bool $isAdmin = false;
    public ?int $idRegion = null;

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
        $sql = "INSERT INTO " . static::$table . " (username, password, score, isAdmin, idRegion) VALUES (:username, :password, :score, :isAdmin, :idRegion);";
        $this->executeQuery($sql, [
            'username' => $this->username,
            'password' => $this->password,
            'score' => $this->score,
            'isAdmin' => ($this->isAdmin) ? 1 : 0,
            'idRegion' => $this->idRegion
        ]);
        $this->id = $this->pdoConnection->lastInsertId();
    }

    public function update()
    {
        $sql = "UPDATE " . static::$table . " SET username = :username, password = :password, score = :score, isAdmin = :isAdmin, idRegion = :idRegion WHERE id = :id;";
        $this->executeQuery($sql, [
            'username' => $this->username,
            'password' => $this->password,
            'score' => $this->score,
            'isAdmin' => ($this->isAdmin) ? 1 : 0,
            'idRegion' => $this->idRegion,
            'id' => $this->id
        ]);
    }

    public function delete()
    {
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
        $this->executeQuery($sql, ['id' => $this->id]);
    }

    /**
     * Récupère un enregistrement spécifique de la table associée à la classe.
     *
     * @param int $id Identifiant unique de l'enregistrement recherché.
     * @return static|null Instance de la classe enfant ou null si non trouvé.
     */
    public static function readByUsername(string $username)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE username = :username";
        $pdoInstance = PDOSingleton::getInstance();
        $stmt = $pdoInstance->getConnection()->prepare($sql);
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($data != null) ? $data : null;
    }

    public static function getScoreBoard()
    {
        $sql = "SELECT username, score, regions.`name` AS `region` FROM " . static::$table . " JOIN regions ON users.idRegion = regions.id ORDER BY score DESC";
        $pdoInstance = PDOSingleton::getInstance();
        $stmt = $pdoInstance->getConnection()->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ($data != null) ? $data : null;
    }

    public static function account(int $id)
    {
        $sql = "SELECT username, isAdmin, regions.`name` AS `region` FROM users
        JOIN regions ON users.idRegion = regions.id WHERE users.id = :id";
        $pdoInstance = PDOSingleton::getInstance();
        $stmt = $pdoInstance->getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($data != null) ? $data : null;
    }
}
