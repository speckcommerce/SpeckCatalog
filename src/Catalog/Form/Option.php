<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Option extends ZendForm
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
    }
}
