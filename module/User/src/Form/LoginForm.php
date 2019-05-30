<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 26.09.2018
 * Time: 10:49
 */

namespace User\Form;

use Zend\Form\Element\Text;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        parent::__construct('login-form');

        $this->setAttribute('method', 'post');
        //$this->setAttribute('action', '/login');

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
                'label' => 'Login or e-mail a',
            ],
        ]);

        $this->add([
            'type' => 'password',
            'name' => 'password',
            'attributes' => [
                'id' => 'password',
            ],
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Log in',
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
                        'min' => 1
                    ],
                ],
            ],
        ]);
    }
}
