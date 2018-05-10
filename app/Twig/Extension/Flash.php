<?php

namespace App\Twig\Extension;

use App\Flash\FlashMessage;

class Flash extends \Twig_Extension
{
    const DEFAULT_CLASS = 'alert-info';

    /**
     * @var array
     */
    private $classes = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'info' => 'alert-info',
        'warning' => 'alert-warning',
    ];

    /**
     * @var FlashMessage
     */
    private $flash;


    public function __construct(FlashMessage $flashMessage)
    {
        $this->flash = $flashMessage;
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('flash', [$this, 'getFlash']),
        ];
    }

    /**
     * @param $path
     * @return string
     */
    public function getFlash($key) {

        $message = $this->flash->get($key);

        if (!is_null($message) && !empty($message)) {

            return sprintf('<div class ="alert %s">%s</div>', $this->getClass($key), $message);
        }
        return '';
    }

     /**
     * @param $key
     * @return mixed|string
     */
    private function getClass($key)
    {
        if (array_key_exists($key, $this->classes)) {
            return $this->classes[$key];
        }
        return self::DEFAULT_CLASS;
    }

}
