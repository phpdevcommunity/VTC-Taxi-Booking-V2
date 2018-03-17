<?php

namespace App\Service;

/**
 * Class Forfait
 * @package App\Service
 */
Class Forfait
{

    protected $forfaits;


    private $packageType;


    public function __construct()
    {
        $this->forfaits = [
            'CDG' => [
                'LISTE' =>
                    [
                        'Tremblay-en-France',
                        'Mauregard',
                        'Le Mesnil-Amelot',
                        'Roissy-en-France',
                        'Terminal',
                        'CDG',
                        'Terminal 3',
                        '2D',
                        'Aéroville',
                        'Roissy',
                        'Charles De Gaulle',
                        'Aéroport',
                        'Airport'
                    ],
                'TARIF' =>
                    [
                        1 => 49.90,
                        2 => 75.00
                    ],
                'FROMORTO' => 'Paris',
                'KM_MAX' => 25
            ],
            'ORLY' => [
                'LISTE' => [
                    'Paray-Vieille-Poste',
                    'Département Essonne',
                    'Orly',
                    'Paray-Vieille-Poste',
                    'Terminal',
                    'Sud',
                    'Ouest',
                    'Aéroport',
                    'Airport'
                ], 'TARIF' => [
                    1 => 44.90,
                    2 => 70.00
                ],
                'FROMORTO' => 'Paris',
                'KM_MAX' => 20
            ],
            'BEAUV' => [
                'LISTE' =>
                    [
                        'Tillé',
                        'Beauvais',
                        'Aéroport Paris',
                        'Aéroport',
                        'Airport'
                    ],
                'TARIF' => [
                    1 => 119.90,
                    2 => 150.00
                ],
                'FROMORTO' => 'Paris',
                'KM_MAX' => 80
            ]

        ];

    }

    /**
     * @param $addressFrom
     * @param $addressTo
     * @return bool
     */
    public function check($addressFrom, $addressTo)
    {


        $from = $addressFrom;
        $to = $addressTo;
        $count = 0;
        foreach ($this->forfaits as $key => $type) {

            foreach ($type['LISTE'] as $list) {
                if (stripos($from, $list) !== false || stripos($to, $list) !== false) {
                    $count++;
                }
                if ($count == 2) {

                    $this->setPackageType($type);
                    return true;
                    break;
                }

            }
            $count = 0;

        }
        return false;

    }

    /**
     * @return mixed
     */
    public function getPackageType()
    {
        return $this->packageType;
    }

    /**
     * @param mixed $packageType
     */
    public function setPackageType($packageType)
    {
        $this->packageType = $packageType;
    }


}
