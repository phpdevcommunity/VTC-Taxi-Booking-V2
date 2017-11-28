<?php
namespace App\Model\Manager;

class AdminManager {

	protected $_bdd;
	
	public function __construct($_db){
		$this->_bdd = $_db;
	}
	public function checkUser($username,$mdpass) {

		$req = $this->_bdd->prepare('SELECT * FROM admins WHERE username = ? AND mdpass = ?');
        $req->execute(array($username, $mdpass));
        $donnees = $req->fetch();
        return $donnees;

	}
}
