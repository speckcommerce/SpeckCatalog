<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Product as ProductModel;
use Zend\Stdlib\Hydrator\ClassMethods;

class Product extends ClassMethods
{
    public function extract(ProductModel $product)
    {
        $data['product_id']      = $product->getProductId();
        $data['name']            = $product->getName();
        $data['description']     = $product->getDescription();
        $data['product_type_id'] = $product->getProductTypeId();
        $data['item_number']     = $product->getItemNumber();
        $data['manufacturer_id'] = $product->getManufacturerId();

        return $data;
    }
}
