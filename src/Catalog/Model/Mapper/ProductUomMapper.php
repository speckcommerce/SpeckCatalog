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
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('parent_product_id = ?', $productId)
                  ->order('price ASC');
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
