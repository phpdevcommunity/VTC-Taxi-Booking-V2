<?php

namespace App\Service;

use MySettings;

Class StripePayment
{

    public function __construct()
    {

        \Stripe\Stripe::setApiKey(MySettings::$_skey_stripe);
    }

    public function payment($token, $email, $price)
    {

        $price = $price * 100;

        try {
            \Stripe\Charge::create(array(
                "amount" => $price, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande : $email ",
                "receipt_email" => $email
            ));

            return true;


        } catch (\Stripe\Error\Card $e) {
            // The card has been declined
            return false;
        }


    }

}
