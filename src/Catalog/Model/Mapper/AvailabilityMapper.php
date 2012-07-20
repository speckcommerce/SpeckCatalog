<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Availability,
    ArrayObject;

class AvailabilityMapper extends ModelMapperAbstract
{
    protected $tableName = "catalog_availability";

    public function getModel($constructor = null)
    {
        return new Availability($constructor);
    }

    public function getByParentProductUomId($productUomId)
    {
        $select = $this->select()->from($this->tableName)
            ->where(array('parent_product_uom_id' => $productUomId));
        return $this->selectWith($select);
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }
}
