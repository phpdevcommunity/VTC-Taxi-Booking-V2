<?php

namespace App\Controller;

use App\Form\CarType;
use App\Form\SettingType;
use App\Model\Car;
use App\Model\Reservation;
use App\Model\Setting;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use App\Repository\SettingRepository;
use App\Upload\ImageUpload;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AppController
{

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws \Exception
     */
    public function home(ServerRequestInterface $request)
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            $date = new \DateTime();
            $date->modify('1 days');

            if (\in_array('key', [])) {
                var_dump('ok');
            }

            $reservationRepo = $this->get(ReservationRepository::class);

            $count['reservations'] = [
                'tomorrow' => $reservationRepo->count(
                    ['dateTransfer' => $date->format('Y-m-d')]
                ),
                'afterTomorrow' => $reservationRepo->count(
                    ['dateTransfer' => $date->modify('1 days')->format('Y-m-d')]
                ),
                'all' => $reservationRepo->count(),
                'price' => number_format($reservationRepo->getTotalPrice(), 2),
            ];

            return $this->render('admin/index.html.twig', [
                'count' => $count['reservations'],
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
            'data' => [],
        ];
        if ($this->isAjax($request) && $this->isGranted('ROLE_ADMIN')) {

            $reservations = ($this->get(ReservationRepository::class))->findAll();

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
     * @throws \Exception
     */
    public function bon(ServerRequestInterface $request, $reference)
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            $reservation = ($this->get(ReservationRepository::class))->findBy(
                ['reference' => $reference],
                true
            );

            if ($reservation) {

                return $this->render('admin/bon.html.twig', [
                    'reservation' => $reservation,
                ]);
            }

        }
        return $this->redirectTo('/login');

    }

    /***
     * @param ServerRequestInterface $request
     * @return Response
     * @throws \Exception
     */
    public function parameter(ServerRequestInterface $request)
    {

        if ($this->isGranted('ROLE_ADMIN')) {

            /**
             * @var Setting $setting
             */
            $settingRepository = $this->get(SettingRepository::class);
            $setting = $settingRepository->find(1);

            $settingType = new SettingType();
            $form = $settingType->buildForm(['setting' => $setting]);

            if ($request->getMethod() == 'POST') {

                $form->validate($request->getParsedBody());
                if ($form->isValid()) {
                    $files = $request->getUploadedFiles();
                    if (!empty($files['background'])) {

                        $file = $files['background'];

                        if ($file instanceof UploadedFileInterface && !empty($file->getClientFilename())) {
                            $imageUpload = new ImageUpload($file);

                            if ($file->getError() !== UPLOAD_ERR_OK || !$imageUpload->isValid()) {
                                foreach ($imageUpload->getErrors() as $error) {
                                    $this->addFlash('error', $error);
                                }
                                return $this->redirectTo($request->getHeaders()['Referer']);
                            }

                            $imageUpload->move('background');
                            $setting->setBackground($imageUpload->getFileName());

                        }
                    }

                    $setting->hydrate($form->getData());
                    $settingRepository->update($setting);

                    $this->addFlash('success', 'Paramètre enregistré');
                    return $this->redirectTo($request->getHeaders()['Referer']);
                }
            }

            return $this->render('admin/parameter.html.twig', [
                'setting' => $setting,
                'form' => $form,
            ]);
        }

        return $this->redirectTo('/login');
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws \Exception
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
            'data' => [],
        ];
        if ($this->isGranted('ROLE_ADMIN')) {

            $cars = ($this->get(CarRepository::class))->findAll();

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
     * @param ServerRequest $request
     * @param null $car
     * @return Response
     * @throws \Exception
     */
    public function carManager(ServerRequestInterface $request, $car = null)
    {

        $carRepository = $this->get(CarRepository::class);

        $car = !is_null($car) ? $carRepository->find($car) : new Car();

        $form = (new CarType())->buildForm(['car' => $car]);

        if ($request->getMethod() == 'POST') {

            $form->validate($request->getParsedBody());

            if ($form->isValid()) {

                $files = $request->getUploadedFiles();

                if (!empty($files['image'])) {

                    $file = $files['image'];
                    if ($file instanceof UploadedFileInterface) {

                        $imageUpload = new ImageUpload($file);
                        if ($file->getError() === UPLOAD_ERR_OK && $imageUpload->isValid()) {
                            $imageUpload->move();
                            $car->setImage($imageUpload->getFileName());
                        }

                    }
                }

                $car->hydrate($form->getData());
                $carRepository->save($car);

                $this->addFlash('success', 'Véhicule enregistré avec succés');
                return $this->redirectTo('/admin/cars');
            }
        }

        return $this->render('admin/edit-add-car.html.twig', [
            'form' => $form,
            'car' => $car,
        ]);
    }

}
