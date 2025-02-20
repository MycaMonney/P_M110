<?php

use Controllers\Logger;
use Controllers\SiteController;

// Routage du site
session_start();
$app->get('/', [SiteController::class, 'home']);
$app->get('/game[/]', [SiteController::class, 'playQuiz']);
$app->get('/scoreboard[/]', [SiteController::class, 'scoreboard']);
$app->get('/account[/]', [SiteController::class, 'account']);


// ACCES AU COMPTE
// Se connecter
$app->get('/login[/]', [SiteController::class, 'login']);
$app->post('/login[/]', [Logger::class, 'login']);

// S'inscrire
$app->get('/register[/]', [SiteController::class, 'register']);
$app->post('/register[/]', [Logger::class, 'register']);

// Se déconnecter
$app->get('/logout[/]', [Logger::class, 'deconnexion']);

// Page admin : accès aux logs
$app->get('/logs[/]', [SiteController::class, 'logs']);
    