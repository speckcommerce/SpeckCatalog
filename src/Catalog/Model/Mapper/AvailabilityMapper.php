<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Availability,
    ArrayObject;

class AvailabilityMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'availability_id';
    protected $tableName = "catalog_availability";

    public function __construct()
    {
        $unsetKeys = array('distributor','companies');
        parent::__construct($unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Availability($constructor);
    }

    public function getByParentProductUomId($productUomId)
    {
        $select = $this->select()->from($this->tableName)
            ->where(array('parent_product_uom_id' => $productUomId));
        return $this->selectMany($select);
    }

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }
}
