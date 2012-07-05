<?php

namespace CatalogManager\Form;

use Zend\Form\Form as ZendForm;

class Choice extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'record_id',
            'attributes' => array(
                'label' => 'Record Id',
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'product_id',
            'attributes' => array(
                'label' => 'Product Id',
                'type' => 'text'
            ),
        ));
        $this->add(array(
            'name' => 'override_name',
            'attributes' => array(
                'label' => 'Override Name',
                'type' => 'text'
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
