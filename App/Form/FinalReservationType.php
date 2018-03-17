<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 10/02/18
 * Time: 19:00
 */

namespace App\Form;

use App\Model\Reservation;
use Fady\Form\FormBuilder;
use Fady\Form\Elements\Input;
use Fady\Form\FormValidator;
use Fady\Form\Interfaces\FormTypeInterface;

/**
 * Class FinalReservationType
 * @package App\Form
 */
class FinalReservationType extends FormBuilder implements FormTypeInterface
{


    /**
     * @param array $options
     * @return $this
     */
    public function buildForm(array $options = [])
    {
        /**
         * @var Reservation $reservation
         */
        $reservation = $options['reservation'];

        $this
            ->setAttributes([
                'name' => 'booking',
                'data-type' => 'form-validation',
                'enctype' => 'multipart/form-data'
            ]);

        $this
            ->add(new Input('firstName', Input::TEXT, [
                'id' => 'firstName',
                'class' => 'form-control',
                'required' => true
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::LENGTH => [
                        'min' => 3,
                        'max' => 50
                    ]
                ]
            )
            ->add(new Input('lastName', Input::TEXT, [
                'id' => 'lastName',
                'class' => 'form-control',
                'required' => true
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::LENGTH => [
                        'min' => 3,
                        'max' => 50
                    ]
                ]
            )
            ->add(new Input('mail', Input::EMAIL, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'username'
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::EMAIL
                ]
            )
            ->add(new Input('phone', Input::TEXT, [
                'id' => 'phone',
                'class' => 'form-control',
                'required' => true
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER
                ]
            )
            ->add(new Input('passengers', Input::NUMBER, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'passengers',
                'min' => 1,
                'max' => $reservation->getCar()->getPlaces(),
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::INT => [
                        'min_range' => 1,
                        'max_range' => $reservation->getCar()->getPlaces()
                    ]
                ]
            )
            ->add(new Input('vol', Input::TEXT, [
                'id' => 'vol',
                'class' => 'form-control',
                'required' => false
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::ALPHANUMERIC
                ]
            )
            ->add(new Input('methodPayment', Input::RADIO, [
                    [
                        'id' => 'money',
                        'class' => 'custom-control-input',
                        'required' => true,
                        'value' => Reservation::PAYMENT_CASH,
                        'checked' => true
                    ],
                    [
                        'id' => 'credit',
                        'class' => 'custom-control-input',
                        'required' => true,
                        'value' => Reservation::PAYMENT_CARD
                    ]
                ]
            ), [
                    FormValidator::REQUIRED,
                    FormValidator::CHOICE => [
                        Reservation::PAYMENT_CASH,
                        Reservation::PAYMENT_CARD,
                    ],
                    FormValidator::INT

                ]
            );

        return $this;
    }


}