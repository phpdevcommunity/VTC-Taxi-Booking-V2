<?php
namespace App\Model\Manager;

use App\Model\Reservation;
use PDO;

class ReservationManager {

    /**
     * @var PDO
     */
	protected $_bdd;
	
	public function __construct($_db){

		$this->_bdd = $_db;
	}
	public function addReservation(Reservation $reservation) {

		$date = str_replace('/', '-', $reservation->getDate());
		$date =  date('Y-m-d', strtotime($date));

		$req = $this->_bdd->prepare('
                              INSERT INTO reservations(reference, depart, nom, prenom, arrivee, date_course, date_heure_reserv, heure_course, km, duree, passagers, no_vol, note, prix, email, method_paiement, telephone, car_id)
			                  VALUES(:reference, :depart, :nom, :prenom, :arrivee, :date_course, :date_heure_reserv, :heure_course, :km, :duree, :passagers, :no_vol, :note, :prix, :email, :method_paiement, :telephone, :car_id)
			                  ');

		$req->execute(array(
			'reference' => $reservation->getReference(),
			'depart' => $reservation->getDepart(),
			'nom' => $reservation->getNom(),
			'prenom' => $reservation->getPrenom(),
			'arrivee' => $reservation->getArrivee(),
			'date_course' => $date,
			'date_heure_reserv' => $reservation->getDateTime(),
			'heure_course' => $reservation->getHeure(),
			'km' => $reservation->getDistance(),
			'duree' => $reservation->getTemps(),
			'passagers' => $reservation->getPassagers(),
			'no_vol' => $reservation->getVol(),
			'note' => $reservation->getNote(),
			'prix' => $reservation->getPrix(),
			'email' => $reservation->getMail(),
			'method_paiement' => $reservation->getPaiement(),
			'telephone' => $reservation->getPhone(),
			'car_id' => $reservation->getCarId()
			));

		return true;

	}
	public function getReservations($page,$pagination) {
		$reponse = $this->_bdd->query('SELECT * FROM reservations ORDER BY id DESC LIMIT ?, ?');
        $reponse->execute(array($page,$pagination));
		$donnees = $reponse->fetchAll();

		$reponse->closeCursor();
		return $donnees;

	}
	public function getReservation($id) {
        $reponse = $this->_bdd->prepare('SELECT * FROM reservations WHERE id = ?');
        $reponse->execute(array($id));
		$donnees = $reponse->fetch();

		$reponse->closeCursor();
		return $donnees;

	}
	public function getCount() {
		$reponse = $this->_bdd->query('SELECT count(*) as total from reservations');

		$donnees = $reponse->fetch();
		return $donnees;
	}
	public function getCountBy($thedate) {

		$reponse = $this->_bdd->prepare('SELECT count(*) as total from reservations WHERE date_course = ? ');
        $reponse->execute(array($thedate));
		$donnees = $reponse->fetch();
		return $donnees;

	}
	public function getPriceAll() {
		$reponse = $this->_bdd->query('SELECT SUM(prix) AS total FROM reservations');

		$donnees = $reponse->fetch();
		return $donnees;
	}
}
