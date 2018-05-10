<?php

namespace App;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Webbym\DependencyInjection\Container;
use App\Routes;
use Fady\Routing\Route;
use Fady\Routing\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class Kernel
{

    /**
     * @var Router
     */
    private $router;

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     * @throws \Exception
     */
    public function load(ServerRequestInterface $request)
    {

        return $this->executeController($request);
    }

    /**
     *
     * @return void
     */
    public function boot()
    {

        $parameters = require dirname(__DIR__) . '/config/config.php';
        $services = require dirname(__DIR__) . '/config/service.php';
        /**
         * @var Container $container
         */
        $container = (Container::getContainer())
            ->setParameters($parameters)
            ->setServices($services);

        $this->router = $container->get(Router::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     * @throws \Exception
     */
    private function executeController(ServerRequestInterface $request)
    {

        $container = Container::getContainer();
        $container
            ->addInstance(ServerRequestInterface::class, $request)
            ->addInstance(ContainerInterface::class, $container);

        /**
         * @var Route $route
         */

        $route = $this->router->getRoute($request->getUri()->getPath());
        $controller = $route->getController();
        $action = $route->getAction();

        $controller = new $controller();

        $arguments = [$request, !empty($route->getVars()) ? implode(',', $route->getVars()) : null];
        $response = \call_user_func_array([$controller, $action], $arguments);

        if (!$response instanceof Response) {

            $msg = 'The controller must return an instance of Psr\Http\Message\Response.';

            if (is_null($response)) {
                $msg .= ' Did you forget to add a return statement somewhere in your controller?';
            }
            throw new \Exception($msg);
        }

        return $response;
    }

}
