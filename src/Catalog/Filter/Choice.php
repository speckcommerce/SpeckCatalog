<?php

namespace Catalog\Filter;

use Zend\InputFilter\InputFilter;

class Choice extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'option_id',
        ));
        $this->add(array(
            'name' => 'product_id',
            'allow_empty' => 'true',
        ));
        $this->add(array(
            'name' => 'override_name',
            'allow_empty' => 'true',
        ));
    }
}
