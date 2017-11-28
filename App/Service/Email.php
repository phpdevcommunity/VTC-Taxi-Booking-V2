<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use App\Model\Reservation;
use MySettings;

Class Email
{

    private $_mailer;

    public function __construct()
    {

        MySettings::configMail();

        date_default_timezone_set('Etc/UTC');
        //Create a new PHPMailer instance
        $this->_mailer = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $this->_mailer->isSMTP();
        $this->_mailer->CharSet = 'UTF-8';
        $this->_mailer->SMTPDebug = 0;
        $this->_mailer->Debugoutput = 'html';
        $this->_mailer->Host = MySettings::$_mail_host;
        $this->_mailer->Port = MySettings::$_mail_port;
        $this->_mailer->SMTPSecure = 'tls';
        $this->_mailer->SMTPAuth = MySettings::$_mail_smtpAuth;;
        $this->_mailer->Username = MySettings::$_mail_userName;
        $this->_mailer->Password = MySettings::$_mail_password;
        $this->_mailer->setFrom(MySettings::$_mail_userName, MySettings::$_mail_name);
    }

    public function sendEmailConfirmation(Reservation $reservation)
    {


        $name = $reservation->getNom() . ' ' . $reservation->getPrenom();

        $this->_mailer->addAddress($reservation->getMail(), $name);
        $this->_mailer->addAddress(MySettings::$_mail_userName, MySettings::$_society);
        //Set the subject line
        $this->_mailer->Subject = 'Réservation n°' . $reservation->getReference() . ' confirmée';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $message = file_get_contents('view/html/booking.html');

        // Replace the % with the actual information
        $message = str_replace('%society_link%', MySettings::$_link, $message);
        $message = str_replace('%society%', strtoupper(MySettings::$_society), $message);
        $message = str_replace('%society_phone%', MySettings::$_phone, $message);
        $message = str_replace('%society_email%', MySettings::$_email, $message);


        $message = str_replace('%username%', $name, $message);
        $message = str_replace('%ref%', $reservation->getReference(), $message);
        $message = str_replace('%date%', $reservation->getDate(), $message);
        $message = str_replace('%heure%', $reservation->getHeure(), $message);
        $message = str_replace('%passager%', $reservation->getPassagers(), $message);
        $message = str_replace('%datetime%', $reservation->getDateTime(), $message);
        $message = str_replace('%depart%', $reservation->getDepart(), $message);
        $message = str_replace('%arrive%', $reservation->getArrivee(), $message);
        $message = str_replace('%typecar%', $reservation->getCar(), $message);
        $message = str_replace('%vol%', $reservation->getVol(), $message);
        $message = str_replace('%note%', $reservation->getNote(), $message);
        $message = str_replace('%tel%', $reservation->getPhone(), $message);
        $message = str_replace('%prix%', $reservation->getPrix(), $message);
        if ($reservation->getPaiement() == 1) {
            $message = str_replace('%payment%', 'Paiement à bord', $message);
        } elseif ($reservation->getPaiement() == 2) {
            $message = str_replace('%payment%', 'Payée par CB', $message);

        }
        $message = str_replace('%prix%', $reservation->getPrix(), $message);

        $this->_mailer->msgHTML($message);
        //Replace the plain text body with one created manually
        $this->_mailer->AltBody = 'This is a plain-text message body';
        if ($this->_mailer->Send()) {
            return true;
        } else {
            return false;
        }
    }

}
