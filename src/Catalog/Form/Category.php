<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Category extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'record_id',
            'attributes' => array(
                'type' => 'hidden'
            ),
            'options' => array(
                'label' => 'Record Id',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
    }
}
