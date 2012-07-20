<?php
namespace Catalog\Model\Mapper;

use Catalog\Model\Category,
    ArrayObject;

class CategoryMapper extends ModelMapperAbstract
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
                  ->join('catalog_category_category_linker', 'catalog_category_category_linker'.'.child_category_id = '.$this->getTableName().'.category_id')
                  ->where('parent_category_id = ?', $categoryId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }

    public function linkParentCategory($parentCategoryId, $categoryId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from('catalog_category_category_linker')
            ->where('parent_category_id = ?', $parentCategoryId)
            ->where('child_category_id = ?', $categoryId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $row = $db->fetchRow($sql);
        if(false === $row){
            $data = new ArrayObject(array(
                'parent_category_id'  => $parentCategoryId,
                'child_category_id' => $categoryId,
            ));
            $result = $db->insert('catalog_category_category_linker', (array) $data);
            if($result !== 1){
                var_dump($result);
                die('something didnt work!');
            }
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
