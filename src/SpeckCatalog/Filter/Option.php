<?php

namespace SpeckCatalog\Filter;

use Zend\Filter\ToNull;
use Zend\InputFilter\InputFilter;

class Option extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'option_id',
            'allow_empty' => true,
            'required' => true,
            'filters'   => [
                new ToNull(ToNull::TYPE_STRING),
            ],
        ]);
        $this->add([
            'name' => 'product_id',
            'required' => false,
            'allow_empty' => true,
        ]);
        $this->add([
            'name' => 'choice_id',
            'required' => false,
            'allow_empty' => true,
        ]);
        $this->add([
            'name' => 'name',
            'required' => true,
        ]);
        $this->add([
            'name' => 'instruction',
            'allow_empty' => true,
        ]);
        $this->add([
            'name' => 'option_type_id',
            'required' => true,
        ]);
        $this->add([
            'name' => 'builder',
            'required' => true,
        ]);
    }
}
