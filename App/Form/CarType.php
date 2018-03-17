<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 10/02/18
 * Time: 19:00
 */

namespace App\Form;


use App\Model\Car;
use Fady\Form\FormBuilder;
use Fady\Form\Elements\Input;
use Fady\Form\FormValidator;
use Fady\Form\Interfaces\FormTypeInterface;

/**
 * Class CarType
 * @package App\Form
 */
class CarType extends FormBuilder implements FormTypeInterface
{


    /**
     * @param array $options
     * @return $this
     */
    public function buildForm(array $options = [])
    {

        /**
         * @var Car $car
         */
        $car = $options['car'];

        $this
            ->setAttributes([
                'enctype' => 'multipart/form-data',
                'autocomplete' => 'off',
                'name' => 'setting',
                'data-type' => 'form-validation',
            ]);


        $this
            ->add(new Input('type', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'type',
                'placeholder' => 'Type du véhicule',
                'value' => $car->getType() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                ]
            )
            ->add(new Input('kmPrice', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'kmPrice',
                'placeholder' => 'Prix au kilometre',
                'value' => $car->getKmPrice() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER
                ]
            )
            ->add(new Input('minutePrice', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'minutePrice',
                'placeholder' => 'Prix à la minute',
                'value' => $car->getMinutePrice() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER
                ]
            )
            ->add(new Input('minimumPrice', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'minimumPrice',
                'placeholder' => 'Tarif minimum',
                'value' => $car->getMinimumPrice() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER
                ]
            )
            ->add(new Input('increase', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'increase',
                'placeholder' => 'Majoration (%)',
                'value' => $car->getIncrease() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER,
                ]
            )
            ->add(new Input('places', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'places',
                'placeholder' => 'Nombre de places max',
                'value' => $car->getPlaces() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER
                ]
            )
            ->add(new Input('bags', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'bags',
                'placeholder' => 'Nombre de bagages max',
                'value' => $car->getBags() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER
                ]
            )
        ;

        return $this;
    }


}