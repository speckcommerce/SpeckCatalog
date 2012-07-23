<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\ProductUom,
    ArrayObject;

class ProductUomMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_product_uom';

    public function __construct($adapter)
    {
        $unsetKeys = array('availabilities','uom','parent_product');
        parent::__construct($adapter, $unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new ProductUom($constructor);
    }

    public function getProductUomsByParentProductId($productId)
    {
        $select = $this->select()->from($this->tableName)
            ->where(array('parent_product_id' => $productId));
            //->order('price ASC');
        return $this->selectMany($select);
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }
}
