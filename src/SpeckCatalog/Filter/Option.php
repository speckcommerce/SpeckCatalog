<?php

namespace SpeckCatalog\Filter;

use Zend\InputFilter\InputFilter;

class Option extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'option_id',
            'allow_empty' => true,
            'required' => true,
            'filters'   => array(
                new \Zend\Filter\Null(\Zend\Filter\Null::TYPE_STRING),
            ),
        ));
        $this->add(array(
            'name' => 'product_id',
            'required' => false,
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'choice_id',
            'required' => false,
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'name',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'instruction',
            'allow_empty' => true,
        ));
        $this->add(array(
            'name' => 'option_type_id',
            'required' => true,
        ));
        $this->add(array(
            'name' => 'builder',
            'required' => true,
        ));
    }
}
