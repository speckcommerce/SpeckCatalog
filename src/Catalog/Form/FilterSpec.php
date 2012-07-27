<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterSpec extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'spec_id',
        ));
        $this->add(array(
            'name' => 'label',
        ));
        $this->add(array(
            'name' => 'value',
        ));
   }
}
