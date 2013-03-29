<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\ProductImage as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class ProductImage extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['image_id']    = $model->getImageId();
        $data['product_id']  = $model->getProductId();
        $data['sort_weight'] = $model->getSortWeight();
        $data['file_name']   = $model->getFileName();
        $data['label']       = $model->getLabel();

        return $data;
    }
}
