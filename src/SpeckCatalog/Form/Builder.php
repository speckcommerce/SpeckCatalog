<?php

namespace SpeckCatalog\Form;

class Builder extends AbstractForm
{
    protected $originalFields = array();

    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'products',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));
    }
}
