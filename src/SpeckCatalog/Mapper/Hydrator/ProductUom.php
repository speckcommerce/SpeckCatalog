<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\ProductUom as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class ProductUom extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['uom_code']    = $model->getUomCode();
        $data['product_id']  = $model->getProductId();
        $data['price']       = $model->getPrice();
        $data['retail']      = $model->getRetail();
        $data['enabled']     = ($model->getEnabled()) ? 1 : 0;
        $data['quantity']    = $model->getQuantity();
        $data['sort_weight'] = $model->getSortWeight();

        return $data;
    }

    public function hydrate($data, $model)
    {
        $model = parent::hydrate($data, $model);
        $model->setEnabled((bool) $model->getEnabled());

        return $model;
    }
}
