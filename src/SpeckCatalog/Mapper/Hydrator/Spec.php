<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Spec as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Spec extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['spec_id']    = $model->getChoiceId();
        $data['product_id'] = $model->getProductId();
        $data['label']      = $model->getLabel();
        $data['value']      = $model->getValue();

        return $data;
    }
}
