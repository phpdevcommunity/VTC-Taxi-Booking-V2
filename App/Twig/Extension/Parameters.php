<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 25/11/17
 * Time: 22:18
 */

namespace App\Twig\Extension;

use App\Config\Config;
use App\Model\Setting;
use Twig_Extension;
use Twig_Function;

/**
 * Class Parameters
 * @package App\Twig\Extension
 */
class Parameters extends Twig_Extension
{

    /**
     * @var Config $config
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
            new Twig_Function('param', [$this, 'param']),
            new Twig_Function('config', [$this, 'config']),
        ];
    }

    /**
     * @param $property
     * @return null
     */
    public function param($property)
    {
        /**
         * @var Setting $setting
         */
        $setting = $this->config->setting;
        $method = 'get'.ucfirst($property);

        if (method_exists($setting, $method)) {

            return $setting->$method();
        }
        return null;
    }

    /**
     * @param $param
     * @return mixed|null
     */
    public function config($param) {

        return $this->config->getParameter($param);
    }

}
