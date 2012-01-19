<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\Availability, 
    ArrayObject;

class AvailabilityMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_availability';
    protected $modelClass = 'Availability';

    public function instantiateModel($row)
    {
        $availability = new Availability;
        $availability->setAvailabilityId($row['availability_id'])
                     ->setParentProductUomId($row['parent_product_uom_id'])
                     ->setCost($row['cost'])
                     ->setDistributorCompanyId($row['distributor_company_id']);
                    
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $availability));
        return $availability;  
    }

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
                $availabilities[] = $this->instantiateModel($row);
            }
            return $availabilities;
        }else{
            return array();
        }
    }  
}
