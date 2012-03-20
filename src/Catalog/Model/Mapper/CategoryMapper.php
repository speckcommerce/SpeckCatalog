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
