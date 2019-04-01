<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 01.04.2019
 * Time: 11:15
 */

namespace User\Form;

use Zend\Form\Form;

class ChangePasswordForm extends Form
{
    public function __construct()
    {
        parent::__construct('changepassword-form');

        $this->setAttribute('method', 'post');
        //$this->setAttribute('action', '/login');

        $this->addElements();
        $this->addInputFilter();
    }

    private function addElements()
    {
        $this->add([
            'type' => 'password',
            'name' => 'old-password',
            'attributes' => [
                'id' => 'old-password',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Old password',
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
                'value' => 'Change password',
            ]
        ]);
    }

    private function addInputFilter()
    {
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'old-password',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1
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