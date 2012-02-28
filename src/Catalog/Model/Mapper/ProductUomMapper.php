<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\ProductUom, 
    ArrayObject;

class ProductUomMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product_uom';

    public function getModel($constructor = null)
    {
        return new ProductUom($constructor);
    }

    public function getProductUomsByParentProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('parent_product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $productUoms = array();
            foreach($rows as $row){
                $productUoms[] = $this->mapModel($row);
            }
            return $productUoms;
        }else{
            return array();
        }
    }  
}
