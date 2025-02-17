<?php

namespace Controllers;

use Exception;
use LDAP\Result;
use Models\Alert;
use Models\ARRegions;
use Models\ARUsers;
use Models\Log;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SiteController
{
    public function home(Request $request, Response $response, array $args): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Home'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'home.php', [
            'drawHeader' => true
        ]);
    }

    public function login(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Login'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'login.php');
    }

    public function register(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Register'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'register.php', [
            'regions' => ARRegions::read()
        ]);
    }

    public function scoreboard(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Scoreboard'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'scoreboard.php', [
            'drawHeader' => true,
            'scoreboard' => ARUsers::getScoreBoard()
        ]);
    }

    public function account(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Account'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");
        return $phpView->render($response, 'account.php', [
            'drawHeader' => true,
            'user' => ARUsers::account($_SESSION['idUser'])
        ]);
    }

    public function logs(Request $request, Response $response): Response
    {
        // Construire la structure de la page
        $dataLayout = ['title' => 'Les logs'];
        $phpView = new PhpRenderer(__DIR__ . '/../views', $dataLayout);
        $phpView->setLayout("_template.php");

        // Instancier la classe Log et enregistrer un message
        return $phpView->render($response, 'logs.php', [
            'drawHeader' => true,
            'logs' => Log::getAllLogs()
        ]);
    }
}
