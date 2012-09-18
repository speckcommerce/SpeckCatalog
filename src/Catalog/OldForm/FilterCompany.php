<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterCompany extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'company_id',
        ));
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
