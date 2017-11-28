<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 25/11/17
 * Time: 22:18
 */

namespace App\Twig\Extension;

use Twig_Extension;
use MySettings;
use Twig_Function;

class Route extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_Function('route', array($this, 'route')),
        );
    }

    public function route($url)
    {
            return MySettings::$_url.$url;
    }

}
