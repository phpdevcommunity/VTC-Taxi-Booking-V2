<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 11/03/18
 * Time: 17:32
 */

namespace App\Flash;

/**
 * Class FlashMessage
 * @package App\Flash
 */
class FlashMessage
{

    const FLASH_NAME = 'flash_message';
    const DEFAULT_CLASS = 'alert-info';

    /**
     * @var array
     */
    private $classes = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'info' => 'alert-info',
        'warning' => 'alert-warning'
    ];

    /**
     * FlashMessage constructor.
     */
    public function __construct()
    {
        if (!array_key_exists(self::FLASH_NAME,$_SESSION)) {
            $_SESSION['flash_message'] = [];
        }
    }


    /**
     * @param $key
     * @param string $message
     */
    public function add($key,string $message) {

        $_SESSION['flash_message'][$key] = $message;
        return $this;

    }

    /**
     * @param $key
     * @return null|string
     */
    public function get($key) {

        if (array_key_exists($key, $_SESSION['flash_message'])) {

            $message = $_SESSION['flash_message'][$key];
            unset($_SESSION['flash_message'][$key]);

            return sprintf('<div class ="alert %s">%s</div>', $this->getClass($key), $message);
        }
        return '';
    }


    /**
     * @param $key
     * @return mixed|string
     */
    public function getClass($key) {

        if (array_key_exists($key,$this->classes)) {
            return $this->classes[$key];
        }
        return self::DEFAULT_CLASS;
    }

}