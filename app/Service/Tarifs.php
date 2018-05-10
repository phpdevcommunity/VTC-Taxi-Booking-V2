<?php

namespace App\Service;

use App\Model\Address;
use App\Model\Car;
use App\Model\Reservation;

/**
 * Class Tarifs
 * @package App\Service
 */
Class Tarifs
{


    private $prix;

    /**
     * @var Car
     */
    private $car;

    /**
     * @var Reservation
     */
    private $reservation;


    /**
     * Tarifs constructor.
     * @param Car|null $car
     * @param Reservation|null $reservation
     * @param Forfait|null $package
     */
    public function __construct(
        Reservation $reservation = null
    )
    {
        $this->reservation = $reservation;
        $this->car = $this->reservation->getCar();
    }

    /**
     * @param $distance
     * @param $temps
     * @return bool
     */
    public function calculation($distance, $temps)
    {

        $distance = $distance * $this->car->getKmPrice();
        $temps = $temps * $this->car->getMinutePrice();
        $price = ceil($distance + $temps);

        $this->setPrice($price);
        return true;

    }

    /**
     * @param Forfait $package
     */
    public function calculationByPackage(Forfait $package)
    {
        /**
         * @var Address $addressFrom
         */
        $addressFrom = $this->reservation->getDetailsAddressFrom();
        /**
         * @var Address $addressTo
         */
        $addressTo = $this->reservation->getDetailsAddressTo();
        $typeCar = $this->reservation->getCarId();

        $packageType = $package->getPackageType();

        if (isset($packageType['TARIF'][$typeCar])) {

            if (
                ($addressFrom->getCity() == $packageType['FROMORTO'])
                || ($addressTo->getCity() == $packageType['FROMORTO'])
            ) {
                $this->setPrice($packageType['TARIF'][$typeCar]);
            } else {
                $algo = $packageType['TARIF'][$typeCar] / $packageType['KM_MAX'];
                $this->setPrice(ceil($this->reservation->getDistance() * $algo));
            }

        } else {

            $this->calculation($this->reservation->getDistance(), $this->reservation->getHowLong());
        }

    }

    /**
     * @param $price
     */
    private function setPrice($price)
    {
        $price = $price < $this->car->getMinimumPrice() ? $this->car->getMinimumPrice() : $price;
        $this->prix = number_format($price, 2);
    }

    public function getPrice()
    {
        return $this->prix;
    }



}
