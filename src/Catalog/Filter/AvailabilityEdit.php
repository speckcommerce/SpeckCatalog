<?php

namespace Catalog\Filter;

class AvailabilityEdit extends Availability
{
    public function __construct()
    {
        parent::__construct();
        $this->add(array(
            'name' => 'original_product_id',
        ));
    }
}
