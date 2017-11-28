<?php

namespace App\Router;

class Route
{
    protected $action;
    protected $controller;
    protected $url;
    protected $varsNames;
    protected $vars = [];

    public function __construct($url, $controller, $action, array $varsNames = [])
    {
        $this->setUrl($url);
        $this->setController($controller);
        $this->setAction($action);
        $this->setVarsNames($varsNames);
    }

    public function hasVars()
    {
        return !empty($this->varsNames);
    }

    public function match($url)
    {
        if (preg_match('`^'.$this->url.'$`', $url, $matches))
        {
            return $matches;
        }
        else
        {
            return false;
        }
    }

    public function setAction($action)
    {
        if (is_string($action))
        {
            $this->action = $action;
        }
    }

    public function setController($controller)
    {
        if (is_string($controller))
        {
            $this->controller = $controller;
        }
    }

    public function setUrl($url)
    {
        if (is_string($url))
        {
            $this->url = $url;
        }
    }

    public function setVarsNames(array $varsNames)
    {
        $this->varsNames = $varsNames;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
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
}
