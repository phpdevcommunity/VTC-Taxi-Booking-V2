<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 14/02/18
 * Time: 20:01
 */

namespace App\Repository;


use App\Model\Car;
use App\Model\DataBase;
use Fady\Repository\Repository;
use PDO;

/**
 * Class CarRepository
 * @package App\Repository
 */
class CarRepository extends Repository
{

    /**
     * CarRepository constructor.
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
        return Car::class;
    }


    /**
     * @return string
     */
    public function getTableName() {

        return 'cars';
    }

}