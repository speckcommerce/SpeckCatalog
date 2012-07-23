<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Company extends ZendForm
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
        $this->add(array(
            'name' => 'phone',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
    }
}
