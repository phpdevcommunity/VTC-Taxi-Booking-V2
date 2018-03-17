<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 14/02/18
 * Time: 20:01
 */

namespace App\Repository;


use App\Model\DataBase;
use App\Model\Reservation;
use Fady\Repository\Repository;
use PDO;

/**
 * Class ReservationRepository
 * @package App\Repository
 */
class ReservationRepository extends Repository
{


    /**
     * ReservationRepository constructor.
     * @param PDO|null $pdo
     */
    public function __construct(PDO $pdo = null)
    {
        $this->pdo = (new DataBase())->connect();

    }


    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        $db = $this->pdo->query('SELECT SUM(Price) FROM reservations');

        return $db->fetchColumn();
    }


    /**
     * @return string
     */
    protected function getEntity()
    {
        return Reservation::class;
    }


    /**
     * @return string
     */
    protected function getTableName()
    {

        return 'reservations';
    }

}