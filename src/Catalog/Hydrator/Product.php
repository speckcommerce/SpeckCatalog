<?php

namespace Catalog\Hydrator;

class Product extends AbstractHydrator
{
    protected $nonDbFields = array('options', 'specs', 'images', 'documents', 'uoms', 'manufacturer');

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
