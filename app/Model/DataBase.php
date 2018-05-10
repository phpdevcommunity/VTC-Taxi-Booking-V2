<?php

namespace App\Model;

use PDO;
use Exception;

/***
 * Class DataBase
 * @package App\Model
 */
class DataBase extends \PDO
{


    const DSN_MYSQL = 'mysql:host=%s;dbname=%s;port=%s';


    public function __construct($host, $dbname, $port, $username, $passwd, $options)
    {
        $dsn = sprintf(self::DSN_MYSQL, $host, $dbname, $port);

        parent::__construct($dsn, $username, $passwd, $options);
    }


}
