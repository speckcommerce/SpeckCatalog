<?php

namespace SpeckCatalog\Filter;

use Zend\Filter\ToNull;
use Zend\InputFilter\InputFilter;

class Spec extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'product_id',
            'required' => true,
            'filters'   => [
                new ToNull(ToNull::TYPE_STRING),
            ],
        ]);
        $this->add([
            'name' => 'spec_id',
            'required' => true,
            'allow_empty' => true,
            'filters'   => [
                new ToNull(ToNull::TYPE_STRING),
            ],
        ]);
        $this->add([
            'name' => 'label',
            'allow_empty' => true,
        ]);
        $this->add([
            'name' => 'value',
            'required' => true,
        ]);
    }
}
