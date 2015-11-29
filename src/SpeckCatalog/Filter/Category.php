<?php

namespace SpeckCatalog\Filter;

use Zend\InputFilter\InputFilter;

class Category extends Inputfilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'category_id',
            'allow_empty' => true,
            'required' => true,
        ]);
        $this->add([
            'name' => 'name',
            'allow_empty' => 'true',
        ]);
    }
}
