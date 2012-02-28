<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Product, 
    ArrayObject;

class ProductMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product';

    public function getModel($constructor = null)
    {
        return new Product($constructor);
    }
}
