<?php

namespace CatalogManager\Form;

use Zend\Form\Form as ZendForm;

class Document extends ZendForm
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
