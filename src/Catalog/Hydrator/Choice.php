<?php

namespace Catalog\Hydrator;

class Choice extends AbstractHydrator
{
    protected $nonDbFields = array('options', 'parent_options', 'product', 'add_price');

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
