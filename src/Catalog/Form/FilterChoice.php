<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterChoice extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'choice_id',
        ));
        $this->add(array(
            'name' => 'product_id',
            'allow_empty' => 'true',
        ));
        $this->add(array(
            'name' => 'override_name',
        ));
    }
}
