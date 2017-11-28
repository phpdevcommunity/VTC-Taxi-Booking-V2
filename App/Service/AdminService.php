<?php
namespace App\Service;

use App\Model\Manager\AdminManager;
use App\Model\DataBase;
use MySettings;

class AdminService {


	private $_bdd;

	public function __construct(){

		$bdd = new AdminManager(DataBase::connect());
		$this->_bdd = $bdd;
	}
	public function checkUser($data) {
		extract($data);
	    $username = strtolower(stripslashes(strip_tags($username)));
		$psw = strip_tags($psw);
		if (!empty($username) && !empty($psw)) {

        	$psw = md5($psw);
        	$check = $this->_bdd->checkUser($username,$psw);


        	if (!empty($check)) {
        		$_SESSION['id_em'] = array('id' => $check['id'], 'username' => $check['username']);
        		return true;
        	}
        	else {
        		MySettings::message('ident_error');
        		return false;
        	}
    	}
    	else {
    		MySettings::message('ident_error');
    		return false;
    	}
	}
}
