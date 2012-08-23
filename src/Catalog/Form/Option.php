<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Option extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'option_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span3',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'instruction',
            'attributes' => array(
                'type' => 'text',
                'class' => 'span2',
            ),
            'options' => array(
                'label' => 'Instruction',
            ),
        ));
        $this->add(array(
            'name' => 'variation',
            'attributes' => array(
                'type' => 'select',
                'options' => array(
                    '1' => 'true',
                    '0' => 'false',
                ),
                'class' => 'span2',
            ),
            'options' => array(
                'label' => 'Variation',
            ),
        ));
        $this->add(array(
            'name' => 'list_type',
            'attributes' => array(
                'type' => 'select',
                'options' => array(
                    'radio' => 'radio',
                    'checkbox' => 'checkbox',
                    'dropdown' => 'dropdown'
                ),
                'class' => 'span2',
            ),
            'options' => array(
                'label' => 'List Type',
            ),
        ));
    }
}
