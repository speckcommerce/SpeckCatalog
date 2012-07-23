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
        ));
        $this->add(array(
            'name' => 'description',
        ));
        $this->add(array(
            'name' => 'manufacturer_company_id',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'item_number',
        ));
    }
}
