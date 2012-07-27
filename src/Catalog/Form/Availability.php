<?php

namespace Catalog\Form;

use Zend\Form\Form as ZendForm;

class Availability extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'availability_id',
            'attributes' => array(
                'type' => 'text'
            ),
        ));
    }
}
