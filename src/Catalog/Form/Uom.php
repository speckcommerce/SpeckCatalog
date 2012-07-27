<?php

namespace CatalogManager\Form;

use Zend\Form\Form as ZendForm;

class Uom extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'uom_code',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
    }
}
