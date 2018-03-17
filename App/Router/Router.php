<?php

namespace App\Router;

class Router
{
    protected $routes = [];

    const NO_ROUTE = 1;

    public function addRoute(Route $route)
    {
        if (!in_array($route, $this->routes)) {
            $this->routes[] = $route;
        }
    }

    /**
     * @param $url
     * @return Route|mixed
     * @throws \Exception
     */
    public function getRoute($url)
    {
        /**
         * @var Route $route
         */
        foreach ($this->routes as $route) {

            $varsValues = $route->match($url);
            if (!is_null($varsValues)) {

                if ($route->hasVars()) {

                    $varsNames = $route->getVarsNames();
                    $listVars = [];
                    foreach ($varsValues as $key => $match) {
                        if ($key !== 0) {
                            $listVars[$varsNames[$key - 1]] = $match;
                        }
                    }

                    $route->setVars($listVars);
                }
                return $route;
            }
        }

        throw new \Exception('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }
}
