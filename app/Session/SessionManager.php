<?php


namespace App\Session;

/**
 * Class SessionManager
 * @package App\Session
 */
class SessionManager implements SessionInterface
{


    /**
     * SessionManager constructor.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @param $value
     * @return SessionManager
     */
    public function add(string $key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed|void
     */
    public function delete(string $key)
    {
        if (array_key_exists($key, $_SESSION)) {
           unset($_SESSION[$key]);
        }
    }

    /**
     * @return mixed|void
     */
    public function clear()
    {
        session_unset();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function exist(string $key)
    {
        return array_key_exists($key, $_SESSION);
    }

}