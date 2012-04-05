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
                  ->from('catalog_category_product_linker')
                  ->join($this->getTableName(), 'catalog_category_product_linker'.'.product_id = '.$this->getTableName().'.product_id') 
                  ->where('category_id = ?', $categoryId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        $choices = array();
        if(count($rows) > 0 ){
            foreach($rows as $row){
                $choices[] = $this->mapModel($row);
            }
        }
        return $choices;
    }   
    public function linkParentCategory($categoryId, $productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from('catalog_category_product_linker')
            ->where('category_id = ?', $categoryId)
            ->where('product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'category_id'  => $categoryId,
                'product_id' => $productId,
            ));
            $result = $db->insert('catalog_category_product_linker', (array) $data);
            if($result !== 1){
                var_dump($result);
                die('something didnt work!');
            }
            
        }
    }   
}
