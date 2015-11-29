<?php

namespace SpeckCatalog\Filter;

use Zend\Filter\ToNull;
use Zend\InputFilter\InputFilter;

class Choice extends Inputfilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'choice_id',
            'allow_empty' => true,
            'filters'   => [
                new ToNull(ToNull::TYPE_STRING),
            ],
        ]);
        $this->add([
            'name' => 'option_id',
        ]);
        $this->add([
            'name' => 'product_id',
            'filters'    => [['name' => 'Null']],
            'allow_empty' => 'true',
        ]);
        $this->add([
            'name' => 'override_name',
            'allow_empty' => 'true',
        ]);
    }
}
