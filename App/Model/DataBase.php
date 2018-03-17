<?php

namespace App\Model;

use PDO;
use Exception;

/***
 * Class DataBase
 * @package App\Model
 */
class DataBase
{

    const HOST_NAME = 'localhost';
    const DBASE_NAME = '';
    const USER = '';
    const PASSWORD = '';

    /**
     * @var PDO $bdd
     */
    private $bdd = null;

    /**
     * @return PDO|string
     */
    public function connect()
    {

        if ($this->bdd === null) {

            try {

                $this->bdd = new PDO(
                    'mysql:host=' . self::HOST_NAME . ';dbname=' . self::DBASE_NAME . ''
                    , '' . self::USER . ''
                    , '' . self::PASSWORD . ''
                    , [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );

            } catch (Exception $e) {

                return $e->getMessage();
            }
        }
        return $this->bdd;
    }
}
