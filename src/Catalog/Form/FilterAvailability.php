<?php

namespace Catalog\Form;

use Zend\InputFilter\InputFilter;

class FilterAvailability extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'availability_id',
        ));
        $this->add(array(
            'name' => 'parent_product_uom_id',
        ));
        $this->add(array(
            'name' => 'distributor_company_id',
        ));
   }
}
