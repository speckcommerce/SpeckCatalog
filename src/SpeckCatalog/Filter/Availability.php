<?php

namespace SpeckCatalog\Filter;

use Zend\InputFilter\InputFilter;

class Availability extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'product_id',
        ]);
        $this->add([
            'name' => 'uom_code',
        ]);
        $this->add([
            'name' => 'quantity',
        ]);
        $this->add([
            'name' => 'distributor_id',
        ]);
        $this->add([
            'name' => 'cost',
            'allow_empty' => false,
        ]);
        $this->add([
            'name' => 'distributor_item_number',
        ]);
        $this->add([
            'name' => 'distributor_uom_code',
        ]);
    }
}
