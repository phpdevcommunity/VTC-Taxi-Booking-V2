<?php

namespace App\Service;
use Psr\Container\ContainerInterface;


/**
 * Class StripePayment
 * @package App\Service
 */
Class StripePayment
{


    public function __construct(ContainerInterface $container)
    {

        \Stripe\Stripe::setApiKey($container->getParameter('stripe.secret_key'));
    }

    /**
     * @param $token
     * @param $email
     * @param $price
     * @return bool
     */
    public function payment(string $token, string $email, $price)
    {

        $price = $price * 100;

        try {
            \Stripe\Charge::create([
                "amount" => $price, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande : $email ",
                "receipt_email" => $email
            ]);

            return true;


        } catch (\Stripe\Error\Card $e) {
            // The card has been declined
            return false;
        }


    }

}
