<?php

if (in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], true)) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

use App\Router\Router;
use App\Router\Route;

require __DIR__ . '/vendor/autoload.php';
session_start();

$request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$router = new Router();
$router->addRoute(new Route('/', 'Controller', 'home'));
$router->addRoute(new Route('/reservation/quotation', 'Controller', 'quotation'));
$router->addRoute(new Route('/reservation/([a-zA-Z0-9]+)', 'Controller', 'booking', ['reference']));
$router->addRoute(new Route('/admin', 'AdminController', 'home'));
$router->addRoute(new Route('/admin/generate/bon', 'AdminController', 'bonAdmin'));
$router->addRoute(new Route('/admin/reservations/data', 'AdminController', 'data'));
$router->addRoute(new Route('/admin/bon/([a-zA-Z0-9]+)', 'AdminController', 'bon', ['id']));
$router->addRoute(new Route('/admin/parameters', 'AdminController', 'parameter'));
$router->addRoute(new Route('/admin/cars', 'AdminController', 'cars'));
$router->addRoute(new Route('/admin/car/edit/([0-9]+)', 'AdminController', 'carManager', ['id']));
$router->addRoute(new Route('/admin/car/add', 'AdminController', 'carManager'));
$router->addRoute(new Route('/admin/cars/data', 'AdminController', 'dataCars'));
$router->addRoute(new Route('/login', 'UserController', 'login'));
$router->addRoute(new Route('/logout', 'UserController', 'logOut'));

try {

    /**
     * @var Route $route
     */
    $route = $router->getRoute($request->getUri()->getPath());
    $controller = 'App\\Controller\\' . $route->getController();
    $action = $route->getAction();
    $execute = new $controller;

    /**
     * @var \GuzzleHttp\Psr7\Response $response
     */
    $response = $execute->$action($request, !empty($route->getVars()) ? implode(',', $route->getVars()) : null);

    \Http\Response\send($response);

} catch (\Exception $e) {


    \Http\Response\send(new \GuzzleHttp\Psr7\Response(404));
}
