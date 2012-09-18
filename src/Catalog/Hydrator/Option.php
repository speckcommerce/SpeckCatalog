<?php

namespace Catalog\Hydrator;

class Option extends AbstractHydrator
{
    protected $nonDbFields = array('parent_products','choices');

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
