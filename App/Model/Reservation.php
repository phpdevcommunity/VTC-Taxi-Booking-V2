<?php

namespace App\Model;

use MySettings;

class Reservation
{

    protected $_depart;
    protected $_arrivee;
    protected $_distance;
    protected $_temps;
    protected $_quelle_date;
    protected $_quelle_heure;

    protected $_reference;

    protected $_passagers;
    protected $_vol;
    protected $_note;

    protected $_prix;

    protected $_method_paiement;

    protected $_prenom;
    protected $_nom;
    protected $_mail;
    protected $_phone;
    protected $_date_time;
    protected $_car_id;
    protected $_car;


    public function __construct($details_res, $details_client)
    {

        extract($details_res);
        $this->_depart = $AD;
        $this->_arrivee = $AA;
        $this->_distance = $KM;
        $this->_temps = $TIME;
        $this->_quelle_date = $QUEL_DATE;
        $this->_quelle_heure = $QUEL_HEURE;
        $this->_reference = $REF;
        $this->_car_id = $ID_CAR;
        $this->_car = $CAR;

        extract($details_client);
        $this->_prenom = MySettings::clean($prenom);
        $this->_nom = MySettings::clean(strtoupper($nom));
        $this->_mail = strtolower(MySettings::clean($email));
        $this->_phone = MySettings::clean($telephone);

        $this->_passagers = MySettings::clean($passagers);
        $this->_vol = MySettings::clean(strtoupper($volNumber));
        $this->_note = MySettings::clean($note);
        $this->_method_paiement = $typePaiement;
        $this->_date_time = date("Y-m-d H:i:s");

        $this->_prix = $PRIX;


    }

    public function checkData()
    {
        if (!preg_match('#^[a-zA-Z]{3,25}$#', $this->_prenom) || !preg_match('#^[a-zA-Z]{3,25}$#', $this->_nom)) {

            MySettings::message('name_error');
            return false;

        } elseif (!preg_match("#^[0-9]{6,}$#", $this->_phone)) {

            MySettings::message('phone_error');
            return false;

        } elseif (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $this->_mail)) {

            MySettings::message('mail_error');
            return false;


        } elseif (!preg_match("#^[1-8]{1}$#", $this->_passagers)) {

            MySettings::message('passagers_error');
            return false;

        } elseif ($this->_method_paiement != 1 && $this->_method_paiement != 2) {

            MySettings::message('choose_payment_error');
            return false;

        } else {

            return true;
        }


    }

    public function getDepart()
    {
        return $this->_depart;
    }

    public function getArrivee()
    {
        return $this->_arrivee;
    }

    public function getDistance()
    {
        return $this->_distance;
    }

    public function getTemps()
    {
        return $this->_temps;
    }

    public function getDate()
    {
        return $this->_quelle_date;
    }

    public function getHeure()
    {
        return $this->_quelle_heure;
    }

    public function getDateTime()
    {
        return $this->_date_time;
    }

    public function getReference()
    {
        return $this->_reference;
    }

    public function getPassagers()
    {
        return $this->_passagers;
    }

    public function getVol()
    {
        return $this->_vol;
    }

    public function getNote()
    {
        return $this->_note;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getPrenom()
    {
        return $this->_prenom;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function getMail()
    {
        return $this->_mail;
    }

    public function getPrix()
    {
        return $this->_prix;
    }

    public function getPaiement()
    {
        return $this->_method_paiement;
    }

    public function getCarId()
    {
        return $this->_car_id;
    }

    public function getCar()
    {
        return $this->_car;
    }
}
