<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Availability, 
    ArrayObject;

class AvailabilityMapper extends ModelMapperAbstract
{
    protected $tableName = 'catalog_availability';

    public function getModel($constructor = null)
    {
        return new Availability($constructor);
    }

    public function getByParentProductUomId($productUomId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('parent_product_uom_id = ?', $productUomId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }    

    public function removeLinker($id)
    {
        //no linker, delete the actual record!
        return $this->deleteById($id);
    }   
}
