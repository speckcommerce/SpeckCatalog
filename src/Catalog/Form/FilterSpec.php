<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterSpec extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'label',
        ));
        $this->add(array(
            'name' => 'value',
        ));
   }
}
