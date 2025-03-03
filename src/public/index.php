<?php
// Indiquer les classes à utiliser

use Models\ARUsers;
use Models\Log;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// Activer le chargement automatique des classes
require __DIR__ . '/../../vendor/autoload.php';

// Créer l'application
$app = AppFactory::create();

// Ajouter certains traitements d'erreurs
$app->addErrorMiddleware(true, true, true);

// Middleware pour la redirection
$app->add(function (Request $request, $handler) {
    $path = $request->getUri()->getPath();

    // Exclure certaines routes pour éviter une boucle infinie
    $excludedRoutes = ['/login', '/register'];

    // Vérification si la route correspond à '/connectionAlert/' suivi de deux paramètres
    if (preg_match('#^/connectionAlert/[^/]+/[^/]+$#', $path)) {
        $excludedRoutes[] = $path; // Ajouter la route dynamiquement
    }

    // Vérifier si l'utilisateur est connecté et rediriger si nécessaire
    if (!isset($_SESSION['idUser']) && !in_array($path, $excludedRoutes)) {
        $response = new \Slim\Psr7\Response();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    return $handler->handle($request);
});

// Définir les routes
require __DIR__ . '/../routes/web.php';

// Lancer l'application
$app->run();
