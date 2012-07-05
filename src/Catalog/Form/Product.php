<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Product extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'record_id',
            'attributes' => array(
                'label' => 'Record Id',
                'type' => 'hidden'
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'label' => 'Name',
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'label' => 'Description',
                'type' => 'textarea'
            ),
        ));
        $this->add(array(
            'name' => 'item_number',
            'attributes' => array(
                'label' => 'Item Number',
                'type' => 'text'
            ),
        ));
    }
}
