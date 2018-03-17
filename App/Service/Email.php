<?php

namespace App\Service;

use App\Config\Config;
use App\Model\Setting;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Model\Reservation;
use MySettings;

/**
 * Class Email
 * @package App\Service
 */
Class Email
{

    /**
     * @var PHPMailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Config
     */
    private $config;

    public function __construct()
    {

        $this->config = new Config();

        $loader = new \Twig_Loader_Filesystem('view');
        $this->twig = new \Twig_Environment($loader, [
            'cache' => false,
        ]);

        date_default_timezone_set('Etc/UTC');

        $this->mailer = new PHPMailer;

        $this->mailer->isSMTP();
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->SMTPDebug = 0;
        $this->mailer->Debugoutput = 'html';
        $this->mailer->Host = $this->config->getParameter('mail_host');
        $this->mailer->Port = $this->config->getParameter('mail_port');
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->SMTPAuth = $this->config->getParameter('mail_smtp_auth');
        $this->mailer->Username = $this->config->getParameter('mail_username');
        $this->mailer->Password = $this->config->getParameter('mail_password');
        try {
            $this->mailer->setFrom(
                $this->config->getParameter('mail_username'),
                $this->config->getParameter('mail_name')
            );
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param Reservation $reservation
     * @return bool|string
     */
    public function sendConfirmation(Reservation $reservation)
    {

        /**
         * @var Setting $settings
         */
        $setting = $this->config->setting;
        $name = $reservation->getLastName() . ' ' . $reservation->getFirstName();

        $this->mailer->addAddress($reservation->getMail(), $name);
        $this->mailer->addAddress($this->config->getParameter('mail_username'), $setting->getSociety());

        $this->mailer->Subject = 'Réservation n°' . $reservation->getReference() . ' confirmée';

        try {

            $content = $this->twig->render('html/booking.html.twig', [
                'reservation' => $reservation,
                'setting' => $setting
            ]);

            $this->mailer->msgHTML($content);

            $this->mailer->AltBody = 'This is a plain-text message body';
            try {

                $this->mailer->Send();
                return true;
            } catch (Exception $e) {

                return false;
            }

        } catch (\Exception $e) {

            return $e->getMessage();
        }

    }

}
