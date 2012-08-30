<?php

namespace Catalog\Mapper;

class Category extends AbstractMapper
{
    protected $tableName = 'catalog_category';
    protected $entityPrototype = '\Catalog\Entity\Category';
    protected $hydrator = 'Catalog\Hydrator\Category';

    public function find($categoryId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('category_id' => (int) $categoryId));
        return $this->selectOne($select);
    }

    public function getChildCategories($parentCategoryId=null, $siteId=1)
    {
        $linker = 'catalog_category_website';
        $table  = $this->getTableName();
        $joinString = $linker . '.category_id = ' . $table . '.category_id';

        $where = $this->where()->equalTo('website_id', $siteId);
        if (null === $parentCategoryId) {
            $where->isNull('parent_category_id');
        } else {
            $where->equalTo('parent_category_id', $parentCategoryId);
        }

        $query = $this->select()
            ->from($table)
            ->join($linker, $joinString)
            ->where($where);
        return $this->selectMany($query);
    }
}
