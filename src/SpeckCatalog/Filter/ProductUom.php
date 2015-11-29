<?php

namespace SpeckCatalog\Filter;

use Zend\InputFilter\InputFilter;

class ProductUom extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'product_id',
            'required' => true,
        ]);
        $this->add([
            'name' => 'price',
            'required' => true,
        ]);
        $this->add([
            'name' => 'retail',
        ]);
        $this->add([
            'name' => 'quantity',
            'required' => true,
        ]);
        $this->add([
            'name' => 'uom_code',
            'required' => true,
        ]);
        $this->add([
            'name' => 'enabled',
            'required' => false,
            'allow_empty' => false,
        ]);
    }
}
