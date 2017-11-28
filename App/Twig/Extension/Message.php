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

class Message extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_Function('notice', array($this, 'notice')),
        );
    }

    public function notice()
    {
        return MySettings::readMessage();
    }

}
