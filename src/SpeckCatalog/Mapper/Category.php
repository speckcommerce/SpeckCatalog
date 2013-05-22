<?php

namespace SpeckCatalog\Mapper;

class Category extends AbstractMapper
{
    protected $tableName = 'catalog_category';
    protected $model = '\SpeckCatalog\Model\Category\Relational';
    protected $tableKeyFields = array('category_id');
    protected $tableFields = array('category_id', 'name', 'seo_title', 'description_html', 'image_file_name');

    public function getChildCategories($parentCategoryId=null, $siteId=1)
    {
        $linker = 'catalog_category_website';
        $table  = $this->getTableName();
        $joinString = $linker . '.category_id = ' . $table . '.category_id';

        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('website_id', $siteId);
        if (null === $parentCategoryId) {
            $where->isNull('parent_category_id');
        } else {
            $where->equalTo('parent_category_id', $parentCategoryId);
        }

        $query = $this->getSelect()
            ->join($linker, $joinString)
            ->where($where);
        return $this->selectManyModels($query);
    }

    public function getByProductId($productId, $siteId=1)
    {
        $table  = 'catalog_category';
        $linker = 'catalog_category_product';
        $joinString = $linker . '.category_id = ' . $table . '.category_id';

        $where = new \Zend\Db\Sql\Where();
        $where->equalTo($linker . '.website_id', $siteId);
        $where->equalTo($linker . '.product_id', $productId);

        $select = $this->getSelect($table)
            ->join($linker, $joinString)
            ->where($where);
        //echo str_replace('"','',$select->getSqlString()); die();
        return $this->selectOneModel($select);
    }

    public function getParentCategory($categoryId, $siteId=1)
    {
        $table  = 'catalog_category_website';
        $linker = 'catalog_category';
        $joinString = $table . '.parent_category_id = ' . $linker . '.category_id';
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('website_id', $siteId);
        $where->equalTo($table . '.category_id', $categoryId);
        $where->isNotNull($table . '.parent_category_id');

        $select = $this->getSelect($table)
            ->join($linker, $joinString)
            ->where($where);
        return $this->selectOneModel($select);
    }

    public function addProduct($categoryId, $productId, $siteId=1)
    {
        $table = 'catalog_category_product';
        $row = array(
            'category_id' => $categoryId,
            'product_id' => $productId,
            'website_id' => $siteId,
        );
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->selectOne($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }

    public function addCategory($parentCategoryId = null, $categoryId, $siteId=1)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->equalTo('website_id', $siteId)
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
        $select = $this->getSelect($table)
            ->where($where);
        $result = $this->selectOne($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }

    /**
     * @return siteId
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @param $siteId
     * @return self
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
        return $this;
    }
}
