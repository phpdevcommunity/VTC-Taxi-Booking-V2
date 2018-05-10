<?php

namespace App\Controller;

use App\Form\FinalReservationType;
use App\Form\StartReservationType;
use GuzzleHttp\Psr7\Response;
use App\Model\Reservation;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use App\Service\StripePayment;
use App\Service\Email;
use App\Service\GoogleApi;
use App\Service\Forfait;
use App\Model\Address;
use App\Service\Tarifs;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class Controller
 * @package App\Controller
 */
class HomeController extends AppController
{

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws \Exception
     */
    public function home(ServerRequestInterface $request)
    {

        $reservationType = new StartReservationType();
        $reservationType->setAction('reservation/quotation');
        $form = $reservationType->buildForm();

        return $this->render(
            'index.html.twig', [
                'home' => true,
                'form' => $form
            ]
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param $bookingNumber
     * @return Response
     * @throws \Exception
     */
    public function booking(ServerRequestInterface $request, $bookingNumber)
    {

        if (
            ctype_alnum($bookingNumber)
            &&
            isset($_SESSION[$bookingNumber])
            &&
            !empty($_SESSION[$bookingNumber])
        ) {

            /**
             * @var Reservation $reservation
             */
            $reservation = $_SESSION[$bookingNumber];

            $reservationType = new FinalReservationType();
            $form = $reservationType->buildForm(['reservation' => $reservation]);

            if ($request->getMethod() == 'POST') {

                $data = $request->getParsedBody();
                $form->validate($data);

                if ($form->isValid()) {
                    $reservation->hydrate($form->getData());
                    $payment = $reservation->getMethodPayment();

                    $statusPayment = false;
                    if (
                        $payment === Reservation::PAYMENT_CARD
                        &&
                        isset($data['stripeToken'])
                    ) {

                        $token = $data['stripeToken'];
                        $stripePayment = $this->get(StripePayment::class);
                        $statusPayment = $stripePayment->payment(
                            $token,
                            $reservation->getMail(),
                            $reservation->getPrice()
                        );

                    } elseif ($payment === Reservation::PAYMENT_CASH) {
                        $statusPayment = true;
                    }

                    $reservationRepository = $this->get(ReservationRepository::class);

                    if ($statusPayment === true) {

                        $reservationRepository->save($reservation);

                        try {
                            ($this->get(Email::class))->sendConfirmation($reservation);
                        }catch (\Exception $e) {
                            $this->addFlash(
                                'error',
                                'l\'email de confirmation n\'a pa pu être envoyé.'
                            );
                        }
                        $this->getSession()->delete($bookingNumber);
                    }
                    return $this->render('confirmation.html.twig', [
                            'reservation' => $reservation,
                            'payment' => $statusPayment,
                        ]
                    );
                }

            }
            return $this->render(
                'booking.html.twig', [
                    'reservation' => $reservation,
                    'form' => $form,
                ]
            );

        }

        return $this->redirectTo('/');
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function quotation(ServerRequestInterface $request)
    {

        $reservationType = new StartReservationType();
        $form = $reservationType->buildForm();

        if ($request->getMethod() == 'POST') {

            $form->validate($request->getParsedBody());
            if ($form->isValid()) {

                $reservation = new Reservation($form->getData());
                $car = ($this->get(CarRepository::class))->find($reservation->getCarId());
                if (!$car) {
                    $this->addFlash(
                        'error',
                        'Aucun véhicule n\'est disponible pour le moment'
                    );

                    return $this->redirectTo($request->getHeaders()['Referer']);
                }

                $reservation->setCar($car);

                /**
                 * @var GoogleApi $googleApi
                 */
                $googleApi = $this->get(GoogleApi::class);

                $infoRoute = $googleApi->getRoute($reservation->getDepart(), $reservation->getArrival());

                if ($infoRoute) {

                    $reservation
                        ->setDistance($googleApi->getDistance())
                        ->setHowLong($googleApi->getTemps())
                        ->setDetailsAddressFrom(new Address($googleApi->getAddressDepart()))
                        ->setDetailsAddressTo(new Address($googleApi->getAddressArrival()));

                    $price = new Tarifs($reservation);
                    $package = new Forfait();

                    if ($package->check($googleApi->getAddressDepart(), $googleApi->getAddressArrival())) {
                        $price->calculationByPackage($package);
                    } else {
                        $price->calculation($googleApi->getDistance(), $googleApi->getTemps());
                    }

                    $reservation->setPrice($price->getPrice());
                    $this->getSession()->add($reservation->getReference(),$reservation);
                    
                    if ($this->isAjax($request)) {

                        return new Response(200, [], json_encode($reservation));

                    } else {

                        return $this->redirectTo('/reservation/' . $reservation->getReference());
                    }
                } else {
                    $this->addFlash('error', 'Informations incorrecte !');
                }

            }

            return $this->redirectTo($request->getHeaders()['Referer']);
        }

        return $this->redirectTo('/');
    }
}
