<?php

namespace Catalog\Hydrator;

class Document extends AbstractHydrator
{
    protected $nonDbFields = array();

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
