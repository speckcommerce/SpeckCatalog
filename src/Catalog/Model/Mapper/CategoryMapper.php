<?php
namespace Catalog\Model\Mapper;

use Catalog\Model\Category,
    ArrayObject;

class CategoryMapper extends ModelMapperAbstract
{
    protected $primaryKey = 'category_id';
    protected $tableName = 'catalog_category';

    protected $categoryLinkerTableName = 'catalog_category_category_linker';

    public function __construct($adapter)
    {
        $unsetKeys = array('products', 'categories', 'parent_category_id');
        parent::__construct($adapter, $unsetKeys);
    }

    public function getModel($constructor = null)
    {
        return new Category($constructor);
    }

    public function getChildCategories($categoryId)
    {
        $linker = $this->categoryLinkerTableName;
        $select = $this->select()->from($this->tableName)
                  ->join($linker, $linker . '.child_category_id = ' . $this->tableName . 'category_id')
                  ->where(array($linker . '.parent_category_id' => $categoryId));

        return $this->selectMany($select);
    }

    public function linkParentCategory($parentCategoryId, $categoryId)
    {
        $row = array(
            'parent_category_id' => $parentCategoryId,
            'child_category_id' => $categoryId,
        );
        return $this->add($row, $this->categoryLinkerTableName);
    }
}
