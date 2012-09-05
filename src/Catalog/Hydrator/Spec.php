<?php

namespace Catalog\Hydrator;

class Spec extends AbstractHydrator
{
    protected $nonDbFields = array();

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
