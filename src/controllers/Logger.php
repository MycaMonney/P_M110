<?php

namespace Controllers;

use Exception;
use Models\ARUsers;
use Models\Log;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Logger
{
    public function login(Request $request, Response $response): Response
    {
        if (isset($_SESSION['idUser'])) {
            return $response->withHeader('Location', '/')->withStatus(302);
            die();
        }

        // Construire la structure de la page
        $dataLayout = ['title' => 'Flaglog'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");

        // Récupérer les informations
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Traitement
        $conn = Logger::verifLogIn($username, $password);
        if (is_string($conn)) {
            // Générer le rendu
            return $phpView->render($response, 'login.php', [
                'header' => false,
                'message' => $conn
            ]);
        } else {
            // J'ai récupéré l'ID du compte
            $_SESSION['idUser'] = $conn;
            Log::create("L'utilisateur " . $_SESSION['idUser'] . " s'est connecté.", 'info');
            return $response->withHeader('Location', '/')->withStatus(302);
        }
        die();
    }

    public static function register(Request $request, Response $response, array $args): Response
    {
        if (isset($_SESSION['idUser'])) {
            return $response->withHeader('Location', '/')->withStatus(302);
            die();
        }
        // Construire la structure de la page
        $dataLayout = ['title' => 'Projet'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");

        // Récupérer les informations
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $region = (int)filter_input(INPUT_POST, 'region', FILTER_SANITIZE_NUMBER_INT);
        var_dump(
            $username,
            $password,
            $region
        );

        // L'enregistrer
        $conn = Logger::verifRegister($username);
        if (is_string($conn)) {
            return $phpView->render($response, 'register.php', [
                'message' => $conn
            ]);
        } else {
            // Création du compte
            $newUser = new ARUsers();
            $newUser->username = $username;
            $newUser->password = password_hash($password, PASSWORD_DEFAULT);
            $newUser->score = 0;
            $newUser->idRegion = $region;
            $newUser->create();

            // Sauv. l'ID du compte
            $_SESSION['idUser'] = $newUser->id;
            Log::create("L'utilisateur " . $_SESSION['idUser'] . " a été créé.", 'info');
            return $response->withHeader('Location', '/')->withStatus(302);
        }
        die();
    }

    public static function deconnexion(Request $request, Response $response, array $args): Response
    {
        Log::create("L'utilisateur " . $_SESSION['idUser'] . " s'est déconnecté.", 'info');
        session_unset();
        session_destroy();
        return $response
            ->withHeader('Location', '/')
            ->withStatus(302);
        die();
    }

    public static function verifLogIn(string $username, string $password): string|int
    {
        try {
            $userReceived = ARUsers::readByUsername($username);
            if ($userReceived != null) {
                // Utilisateur trouvé
                if (password_verify($password, $userReceived['password'])) {
                    // Mot de passe correct
                    return $userReceived['id'];
                } else {
                    // Mot de passe incorrect
                    return "Mot de passe incorrect";
                }
            } else {
                // Utilisateur non trouvé
                return "Utilisateur introuvable";
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
            Log::create($th->getMessage(), 'error');
        }
    }

    public static function verifRegister(string $username): string|bool
    {
        try {
            $userReceived = ARUsers::readByUsername($username);
            if ($userReceived != null) {
                // Utilisateur trouvé
                return "$username existe déjà.";
            } else {
                // Utilisateur non trouvé
                return true;
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 1);
            Log::create($th->getMessage(), 'error');
        }
    }
}
