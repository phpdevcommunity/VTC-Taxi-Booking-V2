<?php
namespace App\Model;

use App\Model\Manager\CarsManager;

class Cars {

	private $_type;
	private $_tarif_km;
	private $_tarif_minute;
	private $_tarif_minimum;
	private $_majoration;
	private $_places;

	private $_bdd;
	private $_exist;

	public function __construct($id){
		$bdd = new CarsManager(DataBase::connect());
		$this->_bdd = $bdd;

		$value = $this->_bdd->get($id);
		if (empty($value)) {
			$this->_exist = false;
		}
		else {
			$this->_type = $value['type'];
			$this->_tarif_km = $value['tarif_km'];
			$this->_tarif_minute = $value['tarif_minute'];
			$this->_tarif_minimum = $value['tarif_minimum'];
			$this->_majoration = $value['majoration'];
			$this->_places = $value['places'];
			$this->_exist = true;
		}
	}

    public function getType() {
        return $this->_type;
    }

    public function getTarifKm() {
        return $this->_tarif_km;
    }

    public function getTarifMinute() {
        return $this->_tarif_minute;
    }

    public function getTarifMinimum() {
        return $this->_tarif_minimum;
    }


    public function getMajoration() {
        return $this->_majoration;
    }

    public function getPlaces() {
        return $this->_places;
    }
    public function getExist() {
        return $this->_exist;
    }

}
