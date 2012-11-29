<?php

namespace Catalog\Filter;

use Zend\InputFilter\InputFilter;

class Category extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'category_id',
            'allow_empty' => true,
            'required' => true,
        ));
        $this->add(array(
            'name' => 'name',
            'allow_empty' => 'true',
        ));
    }
}
