<?php

namespace Catalog\Mapper;

class Product extends AbstractMapper
{
    protected $tableName = 'catalog_product';
    protected $entityPrototype = '\Catalog\Entity\Product';
    protected $hydrator = 'Catalog\Hydrator\Product';

    public function find($productId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('product_id' => (int) $productId));
        return $this->selectOne($select);
    }

    public function getByCategoryId($categoryId, $siteId=1)
    {
        $table = $this->getTableName();
        $linker = 'catalog_category_product_linker';
        $joinString = $linker . '.product_id = ' . $table . '.product_id';
        $where = array('category_id' => $categoryId, 'website_id' => $siteId);

        $select = $this->select()
            ->from($table)
            ->join($linker, $joinString)
            ->where($where);
        return $this->selectMany($select);
    }
}
