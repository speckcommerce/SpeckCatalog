<?php

namespace SpeckCatalog\Filter;

use Zend\Filter\ToNull;
use Zend\InputFilter\InputFilter;

class Product extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name'        => 'product_id',
            'required'    => 'true',
            'allow_empty' => 'true',
            'filters'   => [
                new ToNull(ToNull::TYPE_STRING),
            ],
        ]);
        $this->add([
            'name'        => 'name',
            'allow_empty' => false,
        ]);
        $this->add([
            'name'        => 'description',
            'allow_empty' => true,
        ]);
        $this->add([
            'name'        => 'manufacturer_id',
        ]);
        $this->add([
            'name'        => 'item_number',
            'allow_empty' => true,
        ]);
        $this->add([
            'name'        => 'product_type_id',
        ]);
    }
}
