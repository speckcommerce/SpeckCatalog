<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\ProductUom,
    ArrayObject;

class ProductUomMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_product_uom';

    public function getModel($constructor = null)
    {
        return new ProductUom($constructor);
    }

    public function getProductUomsByParentProductId($productId)
    {
        $select = $this->select()->from($this->tableName)
            ->where(array('parent_product_id' => $productId));
            //->order('price ASC');
        return $this->selectWith($select);
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }
}
