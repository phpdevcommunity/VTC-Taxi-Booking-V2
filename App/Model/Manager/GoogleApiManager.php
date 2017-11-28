<?php
namespace App\Model\Manager;

use MySettings;

class GoogleApiManager {

    private $_details;

    public function getDetailsRoute($adresseFrom, $adresseTo) {
         $this->_details = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$adresseFrom.'&destinations='.$adresseTo.'&mode=driving&sensor=false&key='.MySettings::$_keyGoogle;

        $this->_details = json_decode(file_get_contents($this->_details), TRUE);

        //Une fois récupèrer, on les SET dans les varibales prévu à cet effet
        if ($this->_details['rows'][0]['elements'][0]['status'] == 'NOT_FOUND') {
        	MySettings::message('address_error');
            return false;

        }
        else {
        	return $this->_details;
        }


    }
    public function getDetailsAddress($address) {

        $address = str_replace(' ','+',$address);

        $this->_details = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.MySettings::$_keyGoogle;
        
        $this->_details = json_decode(file_get_contents($this->_details), TRUE);
        if ($this->_details['status'] == 'OK') {

            return $this->_details;
        }
        else {
            return false;
        }


    }
}
