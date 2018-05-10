<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 14/02/18
 * Time: 20:01
 */

namespace App\Repository;


use App\Model\DataBase;
use App\Model\User;
use Fady\Repository\Repository;
use PDO;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends Repository
{

    /**
     * UserRepository constructor.
     * @param PDO|null $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return User::class;
    }


    /**
     * @return string
     */
    public function getTableName() {

        return 'users';
    }

}