<?php

namespace SpeckCatalog\Filter;

use Zend\InputFilter\InputFilter;

class Builder extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'products',
        ));
    }
}
