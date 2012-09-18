<?php

namespace Catalog\Filter;

use Zend\InputFilter\InputFilter;

class Option extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'option_id',
        ));
        $this->add(array(
            'name' => 'name',
        ));
        $this->add(array(
            'name' => 'instruction',
        ));
        $this->add(array(
            'name' => 'option_type_id',
        ));
        $this->add(array(
            'name' => 'variation',
        ));
    }
}
