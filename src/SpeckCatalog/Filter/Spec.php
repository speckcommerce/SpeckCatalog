<?php

namespace SpeckCatalog\Filter;

use Zend\Filter\ToNull;
use Zend\InputFilter\InputFilter;

class Spec extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'product_id',
            'required' => true,
            'filters'   => array(
                new ToNull(ToNull::TYPE_STRING),
            ),
        ));
        $this->add(array(
            'name' => 'spec_id',
            'required' => true,
            'allow_empty' => true,
            'filters'   => array(
                new ToNull(ToNull::TYPE_STRING),
            ),
        ));
        $this->add(array(
            'name' => 'label',
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'value',
            'required' => true,
        ));
    }
}
