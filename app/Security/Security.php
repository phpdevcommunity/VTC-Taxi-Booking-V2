<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 17/02/18
 * Time: 19:39
 */

namespace App\Security;


use App\Model\User;

/**
 * Trait Security
 * @package App\Security
 */
trait Security
{


    /**
     * @param $password
     * @return bool
     */
    public function cryptPassword($password)
    {

        return crypt($password, '');

    }

    /**
     * @param $value
     * @param $hashPassword
     * @return bool
     */
    public function passwordValid($value, $hashPassword)
    {

        return password_verify($value, $hashPassword);

    }

    /**
     * @param $role
     * @return bool
     */
    public function isGranted($role)
    {

        if (isset($_SESSION['user'])) {

            $user = $_SESSION['user'];

            if ($user instanceof User) {
                return ($user->getRole() === $role);
            }

        }

        return false;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function generateSession(User $user)
    {

        $_SESSION['user'] = $user;
        return $this;
    }

    /**
     * @return null
     */
    public function getUser()
    {

        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    /**
     * @return bool
     */
    public function removeSession()
    {

        if (isset($_SESSION['user'])) {

            unset($_SESSION['user']);

        }

        return true;

    }

}