<?php

use App\Utils\RouteService;
use Brisum\Lib\ObjectManager;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

require_once './../bootstrap.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$objectManager = ObjectManager::getInstance();
/** @var RouteService $routeService */
$routeService = ObjectManager::getInstance()->get('App\Utils\RouteService');

$routeParameters = null;
try {
    $routeParameters = $routeService->match();
} catch (ResourceNotFoundException $e) {
    echo '404';
    die();
}

if (
    !isset($routeParameters['_controller'])
    || !is_array($routeParameters['_controller'])
) {
    // TODO: Exception
}

$controllerClass = $routeParameters['_controller'][0];
$controllerMethod = $routeParameters['_controller'][1];
$objectManager->invoke(
    $objectManager->create($controllerClass),
    $controllerMethod,
    $routeParameters
);
