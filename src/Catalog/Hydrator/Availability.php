<?php

namespace Catalog\Hydrator;

class Availability extends AbstractHydrator
{
    protected $nonDbFields = array('distributor');

    public function __construct()
    {
        parent::__construct($this->nonDbFields);
    }
}
