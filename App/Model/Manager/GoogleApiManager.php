<?php

namespace App\Model\Manager;


use App\Config\Config;

/**
 * Class GoogleApiManager
 * @package App\Model\Manager
 */
class GoogleApiManager
{

    private $details;

    /**
     * @var Config
     */
    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @param $adresseFrom
     * @param $adresseTo
     * @return bool|mixed
     */
    public function getDetailsRoute($adresseFrom, $adresseTo)
    {
        $this->details = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $adresseFrom . '&destinations=' . $adresseTo . '&mode=driving&sensor=false&key=' . $this->config->getParameter('key_google');

        $this->details = json_decode(file_get_contents($this->details), TRUE);

        //Une fois récupèrer, on les SET dans les varibales prévu à cet effet
        if ($this->details['rows'][0]['elements'][0]['status'] == 'NOT_FOUND') {

            return false;

        } else {
            return $this->details;
        }


    }

    /**
     * @param $address
     * @return bool|mixed
     */
    public function getDetailsAddress($address)
    {

        $address = str_replace(' ', '+', $address);

        $this->details = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $this->config->getParameter('key_google');

        $this->details = json_decode(file_get_contents($this->details), TRUE);
        if ($this->details['status'] == 'OK') {

            return $this->details;
        } else {
            return false;
        }


    }
}
