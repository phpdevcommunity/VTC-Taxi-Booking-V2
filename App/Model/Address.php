<?php
namespace App\Model;

use App\Model\Manager\GoogleApiManager;

class Address {

    private $_city;
    private $_lng;
    private $_lat;
    private $_type;
    private $_address;

    private $_details;

	public function __construct($address) {

		$detailsAddress = new GoogleApiManager();
		$this->_details = $detailsAddress->getDetailsAddress($address);

        $this->_lat = $this->_details['results'][0]['geometry']['location']['lat'];
        $this->_lng = $this->_details['results'][0]['geometry']['location']['lng'];
        $this->_type = $this->_details['results'][0]['types'][0];


        $this->_address = $this->_details['results']['0']['formatted_address'];

		$data = array();
		foreach($this->_details['results']['0']['address_components'] as $element){
			$data[ implode(' ',$element['types']) ] = $element['long_name'];
		}
		$this->_city = $data['locality political'];
		

	}
    public function getCity() {
        return $this->_city;
    }


    public function getLat() {
        return $this->_lat;
    }

    public function getLng() {
        return $this->_lng;
    }


    public function getType() {
        return $this->_type;
    }
    public function getAddress() {
        return $this->_address;
    }

}
