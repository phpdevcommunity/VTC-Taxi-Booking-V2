<?php

namespace App\Router;

/**
 * Class Route
 * @package App\Router
 */
class Route
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var array
     */
    protected $varsNames = [];

    /**
     * @var array
     */
    protected $vars = [];

    /**
     * Route constructor.
     * @param $url
     * @param $controller
     * @param $action
     * @param array $varsNames
     */
    public function __construct($url, $controller, $action, array $varsNames = [])
    {
        $this->setUrl($url)
            ->setController($controller)
            ->setAction($action)
            ->setVarsNames($varsNames);
    }

    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    public function match($url)
    {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            return $matches;
        }
        return null;
    }

    public function setAction(string $action)
    {
        if (is_string($action)) {
            $this->action = $action;
        }
        return $this;
    }

    public function setController(string $controller)
    {
        if (is_string($controller)) {
            $this->controller = $controller;
        }
        return $this;
    }

    public function setUrl(string $url)
    {
        if (is_string($url)) {
            $this->url = $url;
        }
        return $this;
    }

    public function setVarsNames(array $varsNames)
    {
        $this->varsNames = $varsNames;
        return $this;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function getVarsNames()
    {
        return $this->varsNames;
    }

    /**
     * @return mixed
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param mixed $routeName
     */
    public function setRouteName(string $routeName)
    {
        $this->routeName = $routeName;
        return $this;
    }


}
