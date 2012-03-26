<?php

namespace Catalog\Model\Mapper;

use Catalog\Model\Product, 
    ArrayObject;

class ProductMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_product';

    public function getModel($constructor = null)
    {
        return new Product($constructor);
    }
    
    public function getProductsByCategoryId($categoryId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->join('catalog_category_product_linker', 'catalog_category_product_linker'.'.category_id = '.$this->getTableName().'.category_id') 
                  ->where('parent_category_id = ?', $categoryId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        if(count($rows) > 0 ){
            $choices = array();
            foreach($rows as $row){
                $choices[] = $this->mapModel($row);
            }
            return $choices;
        }else{
            return array();
        }
    }   
}
