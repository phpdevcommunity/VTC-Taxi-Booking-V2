<?php
/**
 * @author Fady.m <fadymichel.r@gmail.com>
 */

namespace App\Flash;

use App\Session\SessionInterface;

/**
 * Class FlashMessage
 * @package App\Flash
 */
class FlashMessage
{

    const FLASH_NAME = 'flash_message';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * FlashMessage constructor.
     */
    public function __construct(SessionInterface $sessionManager)
    {
        $this->session = $sessionManager;

        if (!$this->session->exist(self::FLASH_NAME)) {

            $this->session->add(self::FLASH_NAME, []);
        }
    }

    /**
     * @param $key
     * @param string $message
     */
    public function add($type, string $message)
    {

        $flash = $this->session->get(self::FLASH_NAME);
        $flash[$type] = $message;

        $this->session->add(self::FLASH_NAME, $flash);

        return $this;

    }

    /**
     * @param $key
     * @return null|string
     */
    public function get($key)
    {

        if ($this->session->exist(self::FLASH_NAME)) {

            $flash = $this->session->get(self::FLASH_NAME);

            if (array_key_exists($key, $flash)) {

                $message = $flash[$key];

                unset($flash[$key]);
                $this->session->add(self::FLASH_NAME, $flash);
                return $message;

            }
        }
        return null;
    }

}
