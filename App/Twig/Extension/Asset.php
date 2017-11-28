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

class Asset extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_Function('asset', array($this, 'asset')),
        );
    }

    public function asset($path)
    {
            return MySettings::$_url.MySettings::$_view.$path;
    }

}
