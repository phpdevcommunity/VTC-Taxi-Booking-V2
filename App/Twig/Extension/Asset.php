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
 * Class Asset
 * @package App\Twig\Extension
 */
class Asset extends Twig_Extension
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
            new Twig_Function('asset', [$this, 'asset']),
        ];
    }

    /**
     * @param $path
     * @return string
     */
    public function asset($path)
    {
            return $this->config->baseUrl.$path;
    }

}
