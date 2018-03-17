<?php

namespace App\Controller;

use App\Form\CarType;
use App\Form\SettingType;
use App\Model\Car;
use App\Model\Reservation;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use App\Repository\SettingRepository;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AppController
{

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function home(ServerRequestInterface $request)
    {

        if ($this->isGranted('ROLE_ADMIN')) {


            $date = new \DateTime();
            $date->modify('1 days');

            $reservationRepo = new ReservationRepository();

            $count['reservations'] = [
                'tomorrow' => $reservationRepo->count(
                    ['dateTransfer' => $date->format('Y-m-d')]
                ),
                'afterTomorrow' => $reservationRepo->count(
                    ['dateTransfer' => $date->modify('1 days')->format('Y-m-d')]
                ),
                'all' => $reservationRepo->count(),
                'price' => number_format($reservationRepo->getTotalPrice(), 2)
            ];

            return $this->render('admin/index.html.twig', [
                'count' => $count['reservations']
            ]);
        }
        return $this->redirectTo('/login');

    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function data(ServerRequestInterface $request)
    {
        $output = [
            'data' => []
        ];
        if ($this->isAjax($request) && $this->isGranted('ROLE_ADMIN')) {


            $reservations = (new ReservationRepository())->findAll();

            foreach ($reservations as $reservation) {
                /**
                 * @var Reservation $reservation
                 */
                $output['data'][] = [
                    'reference' => $reservation->getReference(),
                    'client' => $reservation->getLastName() . ' ' . $reservation->getFirstName(),
                    'depart' => $reservation->getDepart(),
                    'arrival' => $reservation->getArrival(),
                    'dateTransfer' => (
                    new \DateTime($reservation->getDateTransfer())
                    )->format('d/m/Y')
                    ,
                    'timeTransfer' => $reservation->getTimeTransfer(),
                    'price' => number_format($reservation->getPrice(), 2),
                ];
            }

        }

        return new Response(200, [], json_encode($output));
    }

    /**
     * @param ServerRequestInterface $request
     * @param $reference
     * @return Response
     */
    public function bon(ServerRequestInterface $request, $reference)
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            $reservation = (new ReservationRepository())->findBy(
                ['reference' => $reference],
                true
            );

            if ($reservation) {

                return $this->render('admin/reservation.html.twig', [
                    'reservation' => $reservation,
                    'setting' => $this->getConfig()->setting
                ]);
            }

        }
        return $this->redirectTo('/login');

    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function parameter(ServerRequestInterface $request)
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            $setting = $this->getConfig()->setting;

            $settingType = new SettingType();
            $form = $settingType->buildForm(['setting' => $setting]);

            if ($request->getMethod() == 'POST') {

                $form->validate($request->getParsedBody());

                if ($form->isValid()) {
                    $setting->hydrate($form->getData());

                    (new SettingRepository())->update($setting);

                    $this->addFlash('success', 'Paramètre enregistré');
                    return $this->redirectTo($request->getHeaders()['Referer']);
                }
            }


            return $this->render('admin/parameter.html.twig', [
                'setting' => $setting,
                'form' => $form
            ]);
        }

        return $this->redirectTo('/login');
    }

    /**
     * @param ServerRequestInterface $request
     * @param null $car
     * @return Response
     */
    public function cars(ServerRequestInterface $request)
    {


        if (!$this->isGranted('ROLE_ADMIN')) {

            return $this->redirectTo('/');
        }
        return $this->render('admin/cars.html.twig', [
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function dataCars(ServerRequestInterface $request)
    {
        $output = [
            'data' => []
        ];
        if ($this->isGranted('ROLE_ADMIN')) {


            $cars = (new CarRepository())->findAll();

            foreach ($cars as $car) {
                /**
                 * @var Car $car
                 */

                $output['data'][] = $car->toArray();
            }

        }
        return new Response(200, [], json_encode($output));
    }

    /**
     * @param ServerRequestInterface $request
     * @param null $car
     * @return Response
     */
    public function carManager(ServerRequestInterface $request, $car = null)
    {

        $carRepository = new CarRepository();
        if (!is_null($car)) {
            $car = $carRepository->find($car);
        } else {
            $car = new Car();
        }

        $form = (new CarType())->buildForm(['car' => $car]);

        if ($request->getMethod() == 'POST') {

            $form->validate($request->getParsedBody());
            if ($form->isValid()) {

                $car->hydrate($form->getData());

                $carRepository->save($car);

                $this->addFlash('success', 'Véhicule enregistré avec succés');
                return $this->redirectTo('/admin/cars');
            }
        }

        return $this->render('admin/edit-add-car.html.twig', [
            'form' => $form,
            'car' => $car
        ]);
    }

}
