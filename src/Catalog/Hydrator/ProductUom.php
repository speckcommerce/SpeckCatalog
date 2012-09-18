<?php

namespace Catalog\Hydrator;

class ProductUom extends AbstractHydrator
{
    protected $nonDbFields = array('availabilities');

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
