<?php

namespace App\Session;

interface SessionInterface
{

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function add(string $key, $value);

    /**
     * @param string $key
     * @return mixed
     */
    public function delete(string $key);

    /**
     * @return mixed
     */
    public function clear();

    /**
     * @param string $key
     * @return bool
     */
    public function exist(string $key);

}