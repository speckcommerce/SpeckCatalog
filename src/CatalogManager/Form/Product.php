<?php

namespace CatalogManager\Form;

use Zend\Form\Form as ZendForm;

class Product extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'recordId',
            'attributes' => array(
                'label' => 'Record Id',
                'type' => 'text'
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
                'type' => 'text'
            ),
        ));
    }
}
