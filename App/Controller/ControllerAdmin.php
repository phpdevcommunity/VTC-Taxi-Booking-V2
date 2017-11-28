<?php
namespace App\Controller;

use MySettings;
use App\Service\ReservationService;
use App\Service\AdminService;

class ControllerAdmin extends AppController {

	public $_Reservation;
	public $_Admin;

	public function __construct(){

	    parent::__construct();
		MySettings::loadAdmin();
		$this->_Reservation = new ReservationService();	
		$this->_Admin = new AdminService();	

	}

	public function home($page = null) {

		if (!isset($_SESSION['id_em'])) {

			if (isset($_POST['username']) && isset($_POST['psw']) ) {

			    $adminCheck = $this->_Admin->checkUser($_POST);
			    if ($adminCheck === true) {

                    $this->redirectTo('admin');

			    }

			}

			$this->render('admin/connexion.html.twig', []);
		}
		else {

            if (!isset($page) || !is_numeric($page)) {

                $page = 1;
            }
            $pages = $this->_Reservation->nombreDePages();

            $reservation = $this->_Reservation->getReservations($page);

            if ($reservation === false)  {

                $this->redirectTo('admin');
            }
            $this->render('admin/index.html.twig', ['reservations' => $reservation, 'pages' => $pages]);

        }

	}

    /**
     * @param $id
     */
	public function bon($id) {

		if (!isset($_SESSION['id_em'])) {

            $this->redirectTo('admin');
		}

	    $reservation = $this->_Reservation->getReservation($id);

        if ($reservation === false)  {

            $this->redirectTo('admin');
        }

	    $this->render('admin/bon.html.twig', ['reservation' => $reservation]);
	}

	public function bonAdmin() {

		if (!isset($_SESSION['id_em'])) {

            $this->redirectTo('admin');
		}

        $this->redirectTo('home');

	}

}
