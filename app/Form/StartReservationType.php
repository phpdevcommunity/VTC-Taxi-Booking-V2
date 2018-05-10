<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 10/02/18
 * Time: 19:00
 */

namespace App\Form;

use Fady\Form\FormBuilder;
use Fady\Form\Elements\Input;
use Fady\Form\FormValidator;
use Fady\Form\Interfaces\FormTypeInterface;

/**
 * Class StartReservationType
 * @package App\Form
 */
class StartReservationType extends FormBuilder implements FormTypeInterface
{


    /**
     * @param array $options
     * @return $this
     */
    public function buildForm(array $options = [])
    {

        $this
            ->setAttributes([
                'class' => 'row',
                'enctype' => 'multipart/form-data',
                'autocomplete' => 'off'
            ]);

        $this
            ->add(new Input('depart', Input::TEXT, [
                'class' => 'form-control',
                'placeholder' => 'Adresse, Aéroport, Gares',
                'data-google' => 'autocomplete',
                'autocomplete' => 'off',
                'required' => false,
                'id' => 'depart'
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::LENGTH => [
                        'min' => 3,
                        'max' => 130
                    ]
                ]
            )
            ->add(new Input('arrival', Input::TEXT, [
                'class' => 'form-control',
                'placeholder' => 'Adresse, Aéroport, Gares',
                'data-google' => 'autocomplete',
                'autocomplete' => 'off',
                'required' => true,
                'id' => 'arrival'
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::LENGTH => [
                        'min' => 3,
                        'max' => 130
                    ]
                ]
            )
            ->add(new Input('dateTransfer', Input::TEXT, [
                'class' => 'form-control',
                'data-type' => 'datepicker',
                'required' => true,
                'id' => 'dateTransfer'
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::DATE => [
                        'format' => 'd/m/Y',
                    ]
                ]
            )
            ->add(new Input('timeTransfer', Input::TEXT, [
                'class' => 'form-control',
                'data-type' => 'timepicker',
                'required' => true,
                'id' => 'timeTransfer'
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::TIME => [
                        'format' => 'H:i'
                    ]
                ]
            )
            ->add(new Input('carId', Input::RADIO, [
                [
                    'id' => 'berline-car',
                    'class' => 'custom-control-input',
                    'value' => 1,
                    'checked' => true
                ],
                [
                    'id' => 'van-car',
                    'class' => 'custom-control-input',
                    'value' => 2
                ],

            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::CHOICE => [
                        1,
                        2
                    ],
                    FormValidator::INT
                ]
            );

        return $this;
    }


}