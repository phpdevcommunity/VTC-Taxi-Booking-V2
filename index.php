<?php

use App\Router\Router;
use App\Router\Route;
use App\Controller\Controller;

require __DIR__ . '/vendor/autoload.php';
require 'MySettings.php';

MySettings::load();

$url = isset($_GET['url']) ? $_GET['url'] : 'home';

$router = new Router;
$router->addRoute(new Route('home', 'Controller', 'home'));
$router->addRoute(new Route('reservation/devis', 'Controller', 'devis'));
$router->addRoute(new Route('reservation/([a-zA-Z0-9]+)', 'Controller', 'booking' , ['reference']));
$router->addRoute(new Route('admin', 'ControllerAdmin', 'home'));
$router->addRoute(new Route('logout', 'ControllerAdmin', 'logOut'));
$router->addRoute(new Route('admin/generate/bon', 'ControllerAdmin', 'bonAdmin'));
$router->addRoute(new Route('admin/bon/([0-9]+)', 'ControllerAdmin', 'bon', ['id']));

try {
    $matchedRoute = $router->getRoute($url);


    $controller = 'App\\Controller\\' . $matchedRoute->getController();
    $_GET = array_merge($_GET, $matchedRoute->getVars());
    $action = $matchedRoute->getAction();

    $execute = new $controller;
    $execute->$action(!empty($matchedRoute->getVars()) ? implode(',', $matchedRoute->getVars()) : null);
}
catch (\Exception $e)  {


    $controller = new Controller();
    if ($controller->other($url) === false) {

        header("HTTP/1.0 404 Not Found");

    }
}
