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

    public function persist($category)
    {
        if(null === $category->getCategoryId()) {
            $id = $this->insert($category);
            return $this->find($id);
        }
        $existing = self::find($category->getCategoryId());
        if($existing){
            $where = array('category_id' => $category->getCategoryId());
            $this->update($category, $where);
            return $category;
        } else {
            $id = $this->insert($category);
            return $this->find($id);
        }
    }


    public function addProduct($categoryId, $productId, $siteId=1)
    {
        $table = 'catalog_category_product_linker';
        $row = array(
            'category_id' => $categoryId,
            'product_id' => $productId,
            'website_id' => $siteId,
        );
        $select = $this->select()
            ->from($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }

    public function addCategory($parentCategoryId = null, $categoryId, $siteId=1)
    {
        $where = $this->where()
            ->equalTo('website_id', $siteId)
            ->equalTo('category_id', $categoryId);
        if (null === $parentCategoryId) {
            $where->isNull('parent_category_id');
        } else {
            $where->equalTo('parent_category_id', $parentCategoryId);
        }
        $table = 'catalog_category_website';
        $row = array(
            'category_id' => $categoryId,
            'parent_category_id' => $parentCategoryId,
            'website_id' => $siteId,
        );
        $select = $this->select()
            ->from($table)
            ->where($where);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }
}
