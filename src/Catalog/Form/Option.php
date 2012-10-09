<?php

namespace Catalog\Form;

class Option extends AbstractForm
{
    protected $originalFields = array('option_id');

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
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'options' => array(
                    '0' => 'False',
                    '1' => 'True',
                ),
                'class' => 'span2',
            ),
            'options' => array(
                'label' => 'Variation',
            ),
        ));
        $this->add(array(
            'name' => 'option_type_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'options' => array(
                    '1' => 'Select',
                    '2' => 'Radio',
                    '3' => 'Checkbox',
                ),
                'class' => 'span2',
            ),
            'options' => array(
                'label' => 'Option Type',
            ),
        ));
    }
}
