<?php

namespace SpeckCatalog\Form;

class Spec extends AbstractForm
{
    protected $originalFields = array('spec_id');

    public function __construct()
    {
        parent::__construct();
        $this->add(array(
            'name' => 'spec_id',
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
            'name' => 'label',
            'options' => array(
                'label' => 'Label',
            ),
        ));
        $this->add(array(
            'name' => 'value',
            'options' => array(
                'label' => 'Value',
            ),
        ));
    }
}
