<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 17/02/18
 * Time: 20:45
 */

namespace App\Repository;


use App\Model\DataBase;
use App\Model\Setting;
use Fady\Repository\Repository;
use PDO;

/**
 * Class SettingRepository
 * @package App\Repository
 */
class SettingRepository extends Repository
{

    /**
     * SettingRepository constructor.
     * @param PDO|null $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

    }

    /**
     * @return string
     */
    public function getEntity()
    {
        return Setting::class;
    }


    /**
     * @return string
     */
    public function getTableName() {

        return 'settings';
    }

}