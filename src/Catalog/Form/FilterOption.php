<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterOption extends InputFilter
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
            'name' => 'list_type',
        ));
        $this->add(array(
            'name' => 'variation',
        ));
    }
}
