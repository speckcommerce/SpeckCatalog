<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterProduct extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
            'allow_empty' => 'true',
        ));
        $this->add(array(
            'name' => 'description',
            'allow_empty' => 'true',
        ));
        $this->add(array(
            'name' => 'manufacturer_company_id',
            'required' => 'false',
        ));
        $this->add(array(
            'name' => 'item_number',
            'allow_empty' => 'true',
        ));
    }
}
