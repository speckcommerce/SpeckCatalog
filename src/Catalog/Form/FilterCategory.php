<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterCategory extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
        ));
   }
}
