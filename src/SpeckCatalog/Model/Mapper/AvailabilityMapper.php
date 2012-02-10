<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Availability, 
    ArrayObject;

class AvailabilityMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_availability';
    protected $modelClass = 'Availability';

    public function getByParentProductUomId($productUomId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('parent_product_uom_id = ?', $productUomId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $availabilities = array();
            foreach($rows as $row){
                $availabilities[] = $this->mapModel($row);
            }
            return $availabilities;
        }else{
            return array();
        }
    }  
}
