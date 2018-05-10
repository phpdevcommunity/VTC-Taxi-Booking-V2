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
 * Class LoginType
 * @package App\Form
 */
class LoginType extends FormBuilder implements FormTypeInterface
{


    /**
     * @param array $options
     * @return $this
     */
    public function buildForm(array $options = [])
    {


        $this
            ->setAttributes([
                'name' => 'login',
                'class' => 'form-signin',
                'data-type' => 'form-validation',
                'enctype' => 'multipart/form-data'
            ]);

        $this
            ->add(new Input('mail', Input::EMAIL, [
                'class' => 'form-control',
                'required' => true,
                'id' => 'username',
                'placeholder' => 'Email address'
            ]), [
                    FormValidator::REQUIRED,
                    FormValidator::EMAIL
                ]
            )
            ->add(new Input('password', Input::PASSWORD, [
                'id' => 'password',
                'class' => 'form-control',
                'required' => true,
                'placeholder' => 'Password'
            ]), [
                    FormValidator::REQUIRED,
                ]
            );

        return $this;
    }


}