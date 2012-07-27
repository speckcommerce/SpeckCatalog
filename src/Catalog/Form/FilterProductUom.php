<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterProductUom extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'product_uom_id',
        ));
        $this->add(array(
            'name' => 'price',
        ));
        $this->add(array(
            'name' => 'retail',
        ));
        $this->add(array(
            'name' => 'quantity',
        ));
        $this->add(array(
            'name' => 'uom_code',
        ));







    }
}
