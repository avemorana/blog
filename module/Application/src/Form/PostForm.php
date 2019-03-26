<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 20.03.2019
 * Time: 12:50
 */

namespace Application\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct()
    {
        parent::__construct('post-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        $this->add([
            'type' => 'text',
            'name' => 'title',
            'attributes' => [
                'id' => 'title',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'Title',
            ],
        ]);

        $this->add([
            'type' => 'textarea',
            'name' => 'content',
            'attributes' => [
                'id' => 'content',
                'autocomplete' => 'off',
                'rows' => 15,
            ],
            'options' => [
                'label' => 'Content',
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Ok',
            ]
        ]);
    }

    public function addInputFilter()
    {
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'title',
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
                        'max' => 50
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'content',
            'required' => true,
            'filters' => [
//                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
//                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 20,
                    ],
                ],
            ],
        ]);
    }
}