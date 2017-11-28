<?php
namespace App\Model;

class Settings {

	protected $_bdd;
	
	public function __construct($_db){
		$this->_bdd = $_db;
	}

	public function getAll() {
		$reponse = $this->_bdd->query('SELECT * FROM settings');
		$donnees = $reponse->fetch();

		$reponse->closeCursor();
		return $donnees;

	}

}
