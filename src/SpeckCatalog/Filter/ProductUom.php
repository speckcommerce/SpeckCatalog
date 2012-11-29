<?php

namespace Catalog\Filter;

use Zend\InputFilter\InputFilter;

class ProductUom extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'product_id',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'price',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'retail',
        ));
        $this->add(array(
            'name' => 'quantity',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'uom_code',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'enabled',
            'required' => false,
            'allow_empty' => false,
        ));
    }
}
