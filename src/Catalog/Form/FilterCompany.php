<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterCompany extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
        ));
        $this->add(array(
            'name' => 'phone',
        ));
        $this->add(array(
            'name' => 'email',
        ));
   }
}
