<?php
namespace Catalog\Model\Mapper;

use Catalog\Model\Category, 
    ArrayObject;

class CategoryMapper extends DbMapperAbstract
{
    protected $tableName = 'catalog_category';

    public function getModel($constructor = null)
    {
        return new Category($constructor);
    }

    public function getChildCategories($categoryId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->join('catalog_category_category_linker', 'catalog_category_category_linker'.'.parent_category_id = '.$this->getTableName().'.category_id') 
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

    public function getTableName()
    {
        return $this->tableName;
    }
 
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
        return $this;
    }
}
