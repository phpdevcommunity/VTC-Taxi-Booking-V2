<?php

namespace App\Service;

Class Forfait
{

    protected $_forfaits;


    public function __construct()
    {
        $this->_forfaits = array(
            'CDG' => array('LISTE' => array('Tremblay-en-France', 'Mauregard', 'Le Mesnil-Amelot', 'Roissy-en-France', 'Terminal', 'CDG', 'Terminal 3', '2D', 'Aéroville', 'Roissy', 'Charles De Gaulle', 'Aéroport', 'Airport'), 'TARIF' => array(1 => 49.90, 2 => 75.00), 'FROMORTO' => 'Paris', 'KM_MAX' => 25),

            'ORLY' => array('LISTE' => array('Paray-Vieille-Poste', 'Département Essonne', 'Orly', 'Paray-Vieille-Poste', 'Terminal', 'Sud', 'Ouest', 'Aéroport', 'Airport'), 'TARIF' => array(1 => 44.90, 2 => 70.00), 'FROMORTO' => 'Paris', 'KM_MAX' => 20),
            'BEAUV' => array('LISTE' => array('Tillé', 'Beauvais', 'Aéroport Paris', 'Aéroport', 'Airport'), 'TARIF' => array(1 => 119.90, 2 => 150.00), 'FROMORTO' => 'Paris', 'KM_MAX' => 80)

        );

    }

    public function check($addressFrom, $addressTo)
    {


        $from = $addressFrom;
        $to = $addressTo;
        $count = 0;
        foreach ($this->_forfaits as $key => $value) {

            foreach ($value['LISTE'] as $liste) {
                if (stripos($from, $liste) !== false || stripos($to, $liste) !== false) {
                    $count++;
                }
                if ($count == 2) {

                    return $value;
                    break;
                }

            }
            $count = 0;

        }
        return false;


    }


}
