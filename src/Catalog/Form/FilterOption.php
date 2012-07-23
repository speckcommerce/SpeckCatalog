<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterOption extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
        ));
        $this->add(array(
            'name' => 'instruction',
        ));
        $this->add(array(
            'name' => 'list_type',
        ));
    }
}
