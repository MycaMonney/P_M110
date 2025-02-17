<?php

namespace Models;

use PDO;
use PDOException;

class PDOSingleton
{
    // Instance unique
    private static ?self $instance = null;
    private readonly PDO $pdo;

    // Configuration de la base de données
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'guess_the_flag';
    private const DB_USER = 'root';
    private const DB_PASS = 'Super';
    private const DB_CHARSET = 'utf8mb4';

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct()
    {
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=' . self::DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
        } catch (PDOException $e) {
            // Logguer l'erreur dans un fichier au lieu de la lancer directement en prod
            Log::create("PDO Connection failed: " . $e->getMessage(), 'critical');
            throw new PDOException("Database connection failed. Please try again later.");
        }
    }

    // Méthode pour obtenir l'instance unique
    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    // Empêcher le clonage de l'objet
    private function __clone() {}

    // Empêcher la désérialisation de l'objet
    public function __wakeup() {}

    // Récupère l'objet PDO pour exécuter des requêtes SQL
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
