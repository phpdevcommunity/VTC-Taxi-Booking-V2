<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 25/11/17
 * Time: 22:18
 */

namespace App\Twig\Extension;

use App\Config\Config;
use Twig_Extension;
use Twig_Function;

/**
 * Class Route
 * @package App\Twig\Extension
 */
class Route extends Twig_Extension
{
    /**
     * @var Config
     */
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }


    /**
     * @return array|Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new Twig_Function('route', [$this, 'route']),
        ];
    }

    /**
     * @param $url
     * @return string
     */
    public function route($url)
    {
            return $this->config->baseUrl.$url;
    }

}
