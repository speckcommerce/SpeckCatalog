<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Feature as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Feature extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['feature_id']  = $model->getFeatureId();
        $data['product_id']  = $model->getProductId();
        $data['name']        = $model->getName();
        $data['sort_weight'] = $model->getSortWeight();

        return $data;
    }
}
