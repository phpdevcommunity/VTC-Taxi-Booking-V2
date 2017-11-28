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

class Parameters extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_Function('param', array($this, 'param')),
        );
    }

    public function param($property)
    {
        if (property_exists('MySettings', $property)) {
            return MySettings::$$property;
        }
        return null;
    }

}
