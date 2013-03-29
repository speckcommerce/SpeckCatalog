<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Availability as AvailabilityModel;
use Zend\Stdlib\Hydrator\ClassMethods;

class Availability extends ClassMethods
{
    public function extract(AvailabilityModel $model)
    {
        $data['product_id']              = $model->getProductId();
        $data['uom_code']                = $model->getUomCode();
        $data['distributor_id']          = $model->getDistributorId();
        $data['cost']                    = $model->getCost();
        $data['quantity']                = $model->getQuantity();
        $data['distributor_uom_code']    = $model->getDistributorUomCode();
        $data['distributor_item_number'] = $model->getDistributorItemNumber();

        return $data;
    }
}
