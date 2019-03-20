<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 11:22
 */

namespace User\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct()
    {
        parent::__construct('registration-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    private function addElements()
    {
        $this->add([
            'type' => 'text',
            'name' => 'login',
            'attributes' => [
                'id' => 'login',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Login',
            ],
        ]);

        $this->add([
            'type' => 'password',
            'name' => 'password',
            'attributes' => [
                'id' => 'password',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'type' => 'password',
            'name' => 're-password',
            'attributes' => [
                'id' => 're-password',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Repeat password',
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create new profile',
            ]
        ]);

    }

    private function addInputFilter()
    {
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'login',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 20,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 50
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 're-password',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 50
                    ],
                ],
            ],
        ]);

    }
}