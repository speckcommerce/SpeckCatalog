<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Choice extends ZendForm
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
        $this->add(array(
            'name' => 'type',
            'attributes' => array(
                'label' => 'Type',
                'type' => 'text'
            ),
        ));
    }
}
