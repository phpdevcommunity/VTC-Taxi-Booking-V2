<?php
namespace App\Model\Manager;

class CarsManager {

	protected $_bdd;
	
	public function __construct($_db){
		$this->_bdd = $_db;
	}
	public function getAll() {
		$reponse = $this->_bdd->query('SELECT * FROM cars WHERE etat ="true" ');
		$donnees = $reponse->fetchAll();

		$reponse->closeCursor();
		return $donnees;
	}
	public function get($id) {
        $reponse = $this->_bdd->prepare('SELECT * FROM cars WHERE id = ?');
        $reponse->execute(array($id));
		$donnees = $reponse->fetch();

		$reponse->closeCursor();
		return $donnees;

	}
	public function getCount() {
		$reponse = $this->_bdd->query('SELECT count(*) as total from cars');
		$donnees = $reponse->fetch();

		$reponse->closeCursor();
		return $donnees;
	}
}
