<?php

namespace SpeckCatalog\Form;

class Option extends AbstractForm
{
    protected $originalFields = ['option_id'];

    public function __construct()
    {
        parent::__construct();

        $this->add([
            'name' => 'option_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'choice_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'product_id',
            'attributes' => [
                'type' => 'hidden'
            ],
        ]);
        $this->add([
            'name' => 'name',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Option Group Name (size, color, etc.)',
            ],
        ]);
        $this->add([
            'name' => 'instruction',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Instruction',
            ],
        ]);
        $this->add([
            'name' => 'required',
            'attributes' => [
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Required',
            ],
        ]);
        $this->add([
            'name' => 'builder',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'options' => [
                    '0' => 'False',
                    '1' => 'True',
                ],
            ],
            'options' => [
                'label' => 'Builder',
            ],
        ]);
        $this->add([
            'name' => 'option_type_id',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => [
                'options' => [
                    '' => '---------',
                    '1' => 'Select Box',
                    '2' => 'Radio Buttons',
                    '3' => 'Checkboxes',
                ],
            ],
            'options' => [
                'label' => 'Display Options As',
            ],
        ]);
    }
}
