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

    public function persist($product)
    {
        if(null === $product->getProductId()) {
            $id = $this->insert($product);
            return $this->find($id);
        }
        $existing = self::find($product->getProductId());
        if($existing){
            $where = array('product_id' => $product->getProductId());
            return $this->update($product, $where);
        } else {
            $id = $this->insert($product);
            return $this->find($id);
        }
    }

    public function addOption($productId, $optionId)
    {
        $table = 'catalog_product_option_linker';
        $row = array('product_id' => $productId, 'option_id' => $optionId);
        $select = $this->select()
            ->from($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }
}
