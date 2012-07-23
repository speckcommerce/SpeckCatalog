<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class AbstractFilter extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'record_id',
            'required' => true,
        ));
    }
}
