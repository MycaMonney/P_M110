<?php

use Controllers\Logger;
use Controllers\SiteController;
use Models\Log;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Routage du site
session_start();
$app->get('/', [SiteController::class, 'home']);
$app->get('/scoreboard[/]', [SiteController::class, 'scoreboard']);
$app->get('/account[/]', [SiteController::class, 'account']);


// JEU
$app->get('/game[/]', [SiteController::class, 'playQuiz']);

// Sauvegarde du score
$app->get('/saveScore/{value}', [SiteController::class, 'saveScore']);


// ACCES AU COMPTE
// Se connecter
$app->get('/login[/]', [SiteController::class, 'login']);
$app->post('/login[/]', [Logger::class, 'login']);
$app->get('/connectionAlert/{username}/{password}', function (Request $request, Response $response, array $args): void {
    $username = $args['username'];
    $password = $args['password'];
    Log::create("Tentative désespérée de connexion [$username, $password]", 'error');
});

// S'inscrire
$app->get('/register[/]', [SiteController::class, 'register']);
$app->post('/register[/]', [Logger::class, 'register']);

// Se déconnecter
$app->get('/logout[/]', [Logger::class, 'deconnexion']);

// Page admin : accès aux logs
$app->get('/logs[/]', [SiteController::class, 'logs']);
