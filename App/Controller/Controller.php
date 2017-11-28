<?php

namespace App\Controller;

use App\Model\Reservation;
use App\Service\StripePayment;
use MySettings;
use App\Model\Manager\ReservationManager;
use App\Model\DataBase;
use App\Service\Email;
use App\Model\Cars;
use App\Service\GoogleApi;
use App\Service\Forfait;
use App\Model\Address;
use App\Service\Tarifs;


class Controller extends AppController
{


    public function home()
    {

        $this->render('index.html.twig', array());

    }

    /**
     * @param $bookingNumber
     */
    public function booking($bookingNumber)
    {

        if (ctype_alnum($bookingNumber) && isset($_SESSION[$bookingNumber]) && !empty($_SESSION[$bookingNumber])) {


            $data = $_SESSION[$bookingNumber];

            if (isset($_POST) && !empty($_POST)) {


                $booking = new Reservation($data, $_POST);
                $check = $booking->checkData();
                if ($check === true) {


                    $method_payment = $booking->getPaiement();
                    if ($method_payment == 2 && isset($_POST['stripeToken'])) {

                        $token = $_POST['stripeToken'];
                        $stripePayment = new StripePayment();
                        $etatPayment = $stripePayment->payment($token, $booking->getMail(), $booking->getPrix());

                    } else {
                        $etatPayment = true;
                    }

                    if ($etatPayment !== false) {

                        $reservation = new ReservationManager(DataBase::connect());
                        $reservation->addReservation($booking);

                        $emailBooking = new Email();
                        $emailBooking->sendEmailConfirmation($booking);
                        unset($_SESSION[$bookingNumber]);

                    }
                   $this->render('confirmation.html.twig',['booking' => $data, 'payment' => $etatPayment, 'method' => $method_payment]);
                }
            }
            else {
                $this->render('booking.html.twig', ['booking' => $data]);
            }

        } else {

            $this->redirectTo('home');
        }

    }

    /**
     * @method POST
     */
    public function devis()
    {
        if (isset($_POST) && !empty($_POST)) {

            $data = $_POST;

            $adForm = MySettings::clean($data['depart']);
            $adTo = MySettings::clean($data['arrivee']);
            $rDate = MySettings::clean($data['date-course']);
            $rTime = MySettings::clean($data['heure-course']);
            $typeCar = MySettings::clean($data['type-car']);


            list($dd, $mm, $yyyy) = explode('/', $rDate);
            if (!checkdate($mm, $dd, $yyyy)) {
                MySettings::message('date_error');
                $this->redirectTo('last_route');

            }
            if (!preg_match("/^([01]?[0-9]|2[0-3])\:+[0-5][0-9]$/", $rTime)) {
                MySettings::message('time_error');
                $this->redirectTo('last_route');

            }
            if (!is_numeric($typeCar)) {

                $this->redirectTo('last_route');
            }

            $car = new Cars($typeCar);
            if ($car->getExist() === false) {
                $this->redirectTo('last_route');
            }

            $googleApi = new GoogleApi();
            $infoRoute = $googleApi->getRoute($adForm, $adTo);

            if ($infoRoute === true) {

                $forfait = new Forfait();
                $checkForfait = $forfait->check($adForm, $adTo);

                $details_addressFrom = new Address($googleApi->getAdresseDepart());
                $details_addressTo = new Address($googleApi->getAdresseArrivee());
                $tarif = new Tarifs($car);

                if ($checkForfait === false) {

                    $tarif->priceCalculation($googleApi->getDistance(), $googleApi->getTemps());

                } else {

                    $citys = array(
                        'from' => $details_addressFrom->getCity(),
                        'to' => $details_addressTo->getCity()
                    );

                    $tarif->forfaitCalculation($citys, $googleApi->getDistance(), $googleApi->getTemps(), $checkForfait, $typeCar);
                }
                $thePrice = $tarif->getPrice();

                $bookingNumber = 'N' . mt_rand(10000, 90000);

                $data_course = array('REF' => $bookingNumber,
                    'AD' => $googleApi->getAdresseDepart(),
                    'AD_LAT' => $details_addressFrom->getLat(),
                    'AD_LNG' => $details_addressFrom->getLng(),
                    'AA' => $googleApi->getAdresseArrivee(),
                    'AA_LAT' => $details_addressTo->getLat(),
                    'AA_LNG' => $details_addressTo->getLng(),
                    'KM' => $googleApi->getDistance(),
                    'TIME' => $googleApi->getTemps(),
                    'QUEL_DATE' => $rDate,
                    'QUEL_HEURE' => $rTime,
                    'PRIX' => $thePrice,
                    'ID_CAR' => $typeCar,
                    'CAR' => $car->getType(),

                );

                $_SESSION[$bookingNumber] = $data_course;

                if ($this->isAjax()) {

                    echo json_encode($_SESSION[$bookingNumber]);
                }
                else {
                    $this->redirectTo('reservation/' . $bookingNumber);
                }
            } else {
                $this->redirectTo('last_route');
            }
        } else {
            $this->redirectTo('');
        }
    }

}
