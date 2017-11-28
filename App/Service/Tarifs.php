<?php

namespace App\Service;

use App\Model\Cars;


Class Tarifs
{

    private $_tarif_km;
    private $_tarif_time;
    private $_tarif_minimum;

    private $_prix;

    public function __construct(Cars $car)
    {
        $this->_tarif_km = $car->getTarifKm();
        $this->_tarif_time = $car->getTarifMinute();
        $this->_tarif_minimum = $car->getTarifMinimum();

    }

    public function priceCalculation($distance, $temps)
    {

        $distance = $distance * $this->_tarif_km;
        $temps = $temps * $this->_tarif_time;
        $price = ceil($distance + $temps);

        $this->setPrice($price);
        return true;

    }

    public function forfaitCalculation($city, $distance, $temps, $data_forfait, $typeCar)
    {

        if (isset($data_forfait['TARIF'][$typeCar])) {

            if (($city['from'] == $data_forfait['FROMORTO']) || ($city['to'] == $data_forfait['FROMORTO'])) {
                $this->setPrice($data_forfait['TARIF'][$typeCar]);
            } else {
                $algo = $data_forfait['TARIF'][$typeCar] / $data_forfait['KM_MAX'];
                $this->setPrice(ceil($distance * $algo));
            }
        } else {
            $this->priceCalculation($distance, $temps);
        }

    }

    private function setPrice($prix)
    {

        if ($prix < $this->_tarif_minimum) {
            $prix = $this->_tarif_minimum;
        }
        $this->_prix = number_format($prix, 2);
    }

    public function getPrice()
    {
        return $this->_prix;
    }
}
