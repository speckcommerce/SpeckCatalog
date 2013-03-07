<?php

namespace SpeckCatalog\Form;

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
            'name' => 'choice_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'product_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Option Group Name (size, color, etc.)',
            ),
        ));
        $this->add(array(
            'name' => 'instruction',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Instruction',
            ),
        ));
        $this->add(array(
            'name' => 'required',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Required',
            ),
        ));
        $this->add(array(
            'name' => 'builder',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'options' => array(
                    '0' => 'False',
                    '1' => 'True',
                ),
            ),
            'options' => array(
                'label' => 'Builder',
            ),
        ));
        $this->add(array(
            'name' => 'option_type_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'options' => array(
                    '' => '---------',
                    '1' => 'Select Box',
                    '2' => 'Radio Buttons',
                    '3' => 'Checkboxes',
                ),
            ),
            'options' => array(
                'label' => 'Display Options As',
            ),
        ));
    }
}
