<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 10/02/18
 * Time: 19:00
 */

namespace App\Form;


use App\Model\Setting;
use Fady\Form\FormBuilder;
use Fady\Form\Elements\Input;
use Fady\Form\FormValidator;
use Fady\Form\Interfaces\FormTypeInterface;

/**
 * Class SettingType
 * @package App\Form
 */
class SettingType extends FormBuilder implements FormTypeInterface
{


    /**
     * @param array $options
     * @return $this
     */
    public function buildForm(array $options = [])
    {

        /**
         * @var Setting $setting
         */
        $setting = $options['setting'];

        $this
            ->setAttributes([
                'enctype' => 'multipart/form-data',
                'autocomplete' => 'off',
                'name' => 'setting',
                'data-type' => 'form-validation',
            ]);

        $this
            ->add(new Input('society', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'society',
                'placeholder' => 'Nom de la société',
                'value' => $setting->getSociety() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                ]
            )
            ->add(new Input('numberSociety', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'numberSociety',
                'placeholder' => 'Numéro de SIRET/SIREN',
                'value' => $setting->getNumberSociety() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::ALPHANUMERIC,
                ]
            )
            ->add(new Input('phone', Input::TEL, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'phone',
                'placeholder' => 'Numéro de téléphone',
                'value' => $setting->getPhone() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::NUMBER,
                ]
            )
            ->add(new Input('link', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'link',
                'placeholder' => 'Url du site',
                'value' => $setting->getLink() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                ]
            )
            ->add(new Input('email', Input::EMAIL, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'email',
                'placeholder' => 'Email de la société',
                'value' => $setting->getEmail() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::EMAIL,
                ]
            )
            ->add(new Input('address', Input::TEXT, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'address',
                'placeholder' => 'Adresse de la société',
                'value' => $setting->getAddress() ?: ''
            ]), [
                    FormValidator::REQUIRED,
                ]
            )
            ->add(new Input('background', Input::FILE, [
                    'class' => 'form-control',
                    'required' => false,
                    'id' => 'background',
                    'placeholder' => 'Image principal',
                ])
            )
        ;

        return $this;
    }


}