<?php
/**
 * Created by PhpStorm.
 * User: Anastasiia
 * Date: 02.04.2019
 * Time: 14:31
 */

namespace Application\Form;

use Zend\Form\Form;

class CommentForm extends Form
{
    public function __construct()
    {
        parent::__construct('comment-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();

    }

    public function addElements()
    {
        $this->add([
            'type' => 'text',
            'name' => 'content',
            'attributes' => [
                'id' => 'content',
                'autocomplete' => 'off',
            ],
            'options' => [
                'label' => 'New comment:',
            ],
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Add comment',
            ]
        ]);
    }

    public function addInputFilter()
    {
        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'content',
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
                        'min' => 5,
                        'max' => 255
                    ],
                ],
            ],
        ]);
    }
}