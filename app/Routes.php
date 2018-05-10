<?php
namespace App;

use Fady\Routing\Route;
use Fady\Routing\RouteBuilderInterface;
use App\Controller\HomeController;
use App\Controller\AdminController;
use App\Controller\UserController;

class Routes implements RouteBuilderInterface
{
    /**
     * @return array Route
     */
    public function routes()
    {
        $routes = [
            new Route('/', HomeController::class, 'home'),
            new Route('/reservation/quotation', HomeController::class, 'quotation'),
            new Route('/reservation/([a-zA-Z0-9]+)', HomeController::class, 'booking', ['reference']),
            new Route('/admin', AdminController::class, 'home'),
            new Route('/admin/generate/bon', AdminController::class, 'bonAdmin'),
            new Route('/admin/reservations/data', AdminController::class, 'data'),
            new Route('/admin/bon/([a-zA-Z0-9]+)', AdminController::class, 'bon', ['id']),
            new Route('/admin/parameters', AdminController::class, 'parameter'),
            new Route('/admin/cars', AdminController::class, 'cars'),
            new Route('/admin/car/edit/([0-9]+)', AdminController::class, 'carManager', ['id']),
            new Route('/admin/car/add', AdminController::class, 'carManager'),
            new Route('/admin/cars/data', AdminController::class, 'dataCars'),
            new Route('/login', UserController::class, 'login'),
            new Route('/logout', UserController::class, 'logOut')
        ];

        return $routes;
    }

}