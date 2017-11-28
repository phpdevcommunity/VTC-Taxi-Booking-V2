<?php

use App\Model\Settings;
use App\Model\Manager\ReservationManager;
use App\Model\DataBase;

class MySettings
{

    public static $_keyGoogle;
    public static $_prefixSite;
    public static $_url;
    public static $_view;

    public static $_mail_host;
    public static $_mail_port;
    public static $_mail_smtpAuth;
    public static $_mail_userName;
    public static $_mail_password;
    public static $_mail_name;

    public static $_skey_stripe;
    public static $_pkey_stripe;

    private static $_bdd_settings;

    public static $_society;
    public static $_siret;
    public static $_phone;
    public static $_link;
    public static $_email;
    public static $_adresse;

    public static $_reservations;

    public static function load()
    {
        session_start();
        self::$_keyGoogle = '';
        self::$_prefixSite = 'blackberline/';
        self::$_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/".self::$_prefixSite;
        self::$_view = 'view/';
        self::$_skey_stripe = '';
        self::$_pkey_stripe = '';

        $bdd_settings = new Settings(dataBase::connect());
        self::$_bdd_settings = $bdd_settings;

        $data = self::$_bdd_settings->getAll();

        self::$_society = $data['society'];
        self::$_siret = $data['siret'];
        self::$_phone = $data['phone'];
        self::$_link = $data['link'];
        self::$_email = $data['email'];
        self::$_adresse = $data['adresse'];

    }

    public static function loadAdmin()
    {
        self::$_bdd_settings = new ReservationManager(dataBase::connect());

        $date = date('Y-m-d');
        $oneDays = date('Y-m-d', strtotime($date . "1 days"));
        $twoDays = date('Y-m-d', strtotime($date . "2 days"));
        self::$_reservations['1days'] = self::$_bdd_settings->getCountBy($oneDays);
        self::$_reservations['2days'] = self::$_bdd_settings->getCountBy($twoDays);
        self::$_reservations['all'] = self::$_bdd_settings->getCount();
        self::$_reservations['prix'] = self::$_bdd_settings->getPriceAll();
    }

    public static function configMail()
    {
        self::$_mail_host = '';
        self::$_mail_port = 587;
        self::$_mail_smtpAuth = true;
        self::$_mail_userName = '';
        self::$_mail_password = '';
        self::$_mail_name = strtoupper(MySettings::$_society);

    }

    public static function autoHeader($value = null)
    {

        if ($value == 'home') {
            $referer = '';
        } elseif ($value == 'admin') {
            $referer = 'admin';
        } elseif ($value === null) {
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        } else {
            $referer = $value;

        }
        header('Location: ' . self::$_prefixSite . $referer);
        return ;
    }

    public static function message($option)
    {

        $_SESSION['MSG'] = $option;
    }

    public static function readMessage()
    {

        $reponseArray =
            array(
                'date_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'La date doit être renseignée, veuillez entrer un format de date valide : JJ/MM/AAAA'
                ),
                'time_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'L\'heure doit être renseignée, veuillez entrer un format d\'heure valide : 00:00'
                ),
                'address_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Adresse introuvable, veuillez entrer une adresse valide'
                ),
                'name_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Votre nom et prénom doivent être renseignés, un minimum de 3 caractères est requis.'
                ),
                'phone_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Veuillez renseigner un numéro de téléphone valide, le format doit être numérique : 0655545352.'
                ),
                'passagers_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Le nombre de passagers doit être compris entre 1 et 8'
                ),
                'choose_payment_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Veuillez définir le mode de paiment souhaité.'
                ),
                'mail_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Veuillez entrer un email valide, exemple@gmail.com'
                ),
                'ident_error' => array(
                    'class' => 'w3-panel w3-card-2 w3-pale-yellow w3-border-orange w3-leftbar w3-rightbar',
                    'title' => 'Désolé!',
                    'message' => 'Identifiant ou mot de passe incorrect.'
                ),
                'pseudo_comm_error' => array(
                    'class' => 'alert-danger',
                    'title' => 'Attention',
                    'message' => '<br />Votre pseudo doit contenir au moins 3 caractères ( sans espaces ni caractères spéciaux ) <br /> Votre commentaire doit contenir au moins 10 caractères.'
                ),
                'titre_content_error' => array(
                    'class' => 'alert-danger',
                    'title' => 'Attention',
                    'message' => '<br />Votre titre doit contenir au moins 10 caractères<br /> Votre contenu d\'article doit contenir au moins 10 caractères.')
                ,
                'TimeError' => array(
                    'class' => 'alert-danger',
                    'title' => 'Attention',
                    'message' => 'Veuillez selectionner un format d\'heure valide.
                    ')
            );

        if (isset($_SESSION['MSG']) && isset($reponseArray[$_SESSION['MSG']])) {

            $option = $reponseArray[$_SESSION['MSG']];
            $html = '<div class="alert ' . $option['class'] . '">
				     		<strong>' . $option['title'] . '</strong> ' . $option['message'] . '
					    </div>';
            unset($_SESSION['MSG']);
            return $html;
        }
    }

    public static function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}