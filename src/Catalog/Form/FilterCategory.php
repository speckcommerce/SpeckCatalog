<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterCategory extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'category_id',
        ));
        $this->add(array(
            'name' => 'name',
        ));
   }
}
