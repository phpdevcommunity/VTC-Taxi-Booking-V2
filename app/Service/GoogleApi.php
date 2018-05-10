<?php

namespace App\Service;

use App\Model\Manager\GoogleApiManager;
use Webbym\DependencyInjection\Container;

/**
 * Class GoogleApi
 * @package App\Service
 */
class GoogleApi
{

    /**
     * @var string
     */
    private $addressDepart;

    /**
     * @var string
     */
    private $addressArrival;

    /**
     * @var string
     */
    private $distance;

    /**
     * @var string
     */
    private $temps;

    /**
     * @var Container
     */
    private $container;


    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param null $addressFrom
     * @param null $addressTo
     * @return bool
     */
    public function getRoute($addressFrom = null, $addressTo = null)
    {

        if (empty($addressFrom) || empty($addressTo)) {
            return false;
        } else {

            $this->addressDepart = str_replace(' ', '+', $addressFrom);
            $this->addressArrival = str_replace(' ', '+', $addressTo);

            $detailsRoute = new GoogleApiManager($this->container);

            $data = $detailsRoute->getDetailsRoute($this->addressDepart, $this->addressArrival);

            if ($data) {
                $this->setDistance($data['rows'][0]['elements'][0]['distance']['text']);
                $this->setTemps($data['rows'][0]['elements'][0]['duration']['text']);
                $this->setAddressDepart($data['origin_addresses'][0]);
                $this->setAddressArrival($data['destination_addresses'][0]);
                return true;
            }
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param $distance
     */
    public function setDistance($distance)
    {
        $distance = explode(" ", $distance);
        $this->distance = $distance[0];
    }

    /**
     * @return mixed
     */
    public function getTemps()
    {
        return $this->temps;
    }

    /**
     * @param $temps
     */
    public function setTemps($temps)
    {
        $temps = explode(" ", $temps);
        $this->temps = $temps[0];
    }

    /**
     * @return string
     */
    public function getAddressDepart()
    {
        return $this->addressDepart;
    }

    /**
     * @param string $addressDepart
     */
    public function setAddressDepart($addressDepart)
    {
        $this->addressDepart = $addressDepart;
    }

    /**
     * @return string
     */
    public function getAddressArrival()
    {
        return $this->addressArrival;
    }

    /**
     * @param string $addressArrival
     */
    public function setAddressArrival($addressArrival)
    {
        $this->addressArrival = $addressArrival;
    }


}
