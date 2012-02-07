<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Product, 
    SpeckCatalog\Model\Item,
    ArrayObject;

class ProductMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product';
    protected $modelClass = 'Product';
}
