<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\ProductUom,
    ArrayObject;

class ProductUomMapper extends ModelMapperAbstract
{
    public function getModel($constructor = null)
    {
        return new ProductUom($constructor);
    }

    public function getProductUomsByParentProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTable()->getTableName())
            ->where(array('parent_product_id' => $productId));
            //->order('price ASC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);    
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }  
}
