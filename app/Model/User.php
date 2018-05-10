<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 17/02/18
 * Time: 19:26
 */

namespace App\Model;


use App\Security\Security;
use Fady\Entity\Entity;

/**
 * Class User
 * @package App\Model
 */
class User extends Entity
{

    use Security;

    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $role = self::ROLE_USER;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {

        $this->password = $this->cryptPassword($password);
        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->role = $role;
        return $this;
    }


}