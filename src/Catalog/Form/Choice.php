<?php

namespace Catalog\Form;

class Choice extends AbstractForm
{
    protected $originalFields = array('choice_id');

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
                'label' => 'Product Id',
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'override_name',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Override Name',
            ),
        ));
    }
}
