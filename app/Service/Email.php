<?php

namespace App\Service;

use App\Config\Config;
use App\Model\Setting;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Model\Reservation;
use MySettings;
use Psr\Container\ContainerInterface;
use Webbym\DependencyInjection\Container;

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
     * @var Container
     */
    private $container;

    public function __construct(ContainerInterface $container, \Twig_Environment $twig_Environment, PHPMailer $mailer)
    {

        $this->container = $container;
        $this->twig = $twig_Environment;
        $this->mailer = new $mailer;

        date_default_timezone_set('Etc/UTC');


        $this->mailer->isSMTP();
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->SMTPDebug = 0;
        $this->mailer->Debugoutput = 'html';
        $this->mailer->Host = $this->container->getParameter('mailer.host');
        $this->mailer->Port = $this->container->getParameter('mailer.port');
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->SMTPAuth = $this->container->getParameter('mail_smtp_auth');
        $this->mailer->Username = $this->container->getParameter('mailer.user');
        $this->mailer->Password = $this->container->getParameter('mailer.password');
        try {
            $this->mailer->setFrom(
                $this->container->getParameter('mailer.email'),
                $this->container->getParameter('mailer.name')
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


        $name = $reservation->getLastName() . ' ' . $reservation->getFirstName();

        $this->mailer->addAddress($reservation->getMail(), $name);
        $this->mailer->addAddress($this->container->getParameter('mailer.email'), $setting->getSociety());

        $this->mailer->Subject = 'Réservation n°' . $reservation->getReference() . ' confirmée';

        try {

            $content = $this->twig->render('html/booking.html.twig', [
                'reservation' => $reservation,
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
