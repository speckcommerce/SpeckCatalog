<?php

namespace SpeckCatalog\Model\Mapper;

use SpeckCatalog\Model\ProductUom, 
    SpeckCatalog\Model\Item,
    ArrayObject;

class ProductUomMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product_uom';
    protected $modelClass = 'ProductUom';

    public function instantiateModel($row)
    {
        $productUom = new ProductUom();
        $productUom->setProductUomId($row['product_uom_id'])
                   ->setParentProductId($row['parent_product_id'])
                   ->setPrice($row['price'])
                   ->setRetail($row['retail'])
                   ->setQuantity($row['quantity']);
        $this->events()->trigger(__FUNCTION__, $this, array('model' => $productUom));
        return $productUom;  
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
                $productUoms[] = $this->instantiateModel($row);
            }
            return $productUoms;
        }else{
            return array();
        }
    }  
}
