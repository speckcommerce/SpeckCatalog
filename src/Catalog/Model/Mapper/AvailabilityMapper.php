<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Availability, 
    ArrayObject;

class AvailabilityMapper extends ModelMapperAbstract
{
    public function getModel($constructor = null)
    {
        return new Availability($constructor);
    }

    public function getByParentProductUomId($productUomId)
    {
        $select = $this->newSelect();
        $select->from($this->getTable()->getTableName())
            ->where(array('parent_product_uom_id' => $productUomId));
        return $this->selectMany($select);
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }   
}
