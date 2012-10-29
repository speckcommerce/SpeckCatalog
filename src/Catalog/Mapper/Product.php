<?php

namespace Catalog\Mapper;

class Product extends AbstractMapper
{
    protected $tableName = 'catalog_product';
    protected $relationalModel = '\Catalog\Model\Product\Relational';
    protected $dbModel = '\Catalog\Model\Product';
    protected $hydrator = 'Catalog\Hydrator\Product';
    protected $key = array('product_id');

    public function find(array $data)
    {
        $select = $this->getSelect()
            ->where(array('product_id' => $data['product_id']));
        return $this->selectOne($select);
    }

    public function getByCategoryId($categoryId, $siteId=1)
    {
        $table = $this->getTableName();
        $linker = 'catalog_category_product';
        $joinString = $linker . '.product_id = ' . $table . '.product_id';
        $where = array('category_id' => $categoryId, 'website_id' => $siteId);

        $select = $this->getSelect()
            ->join($linker, $joinString)
            ->where($where);
        return $this->selectMany($select);
    }

    public function persist($product)
    {
        $dbProduct = $this->getDbModel($product);
        if(null === $product->getProductId()) {
            $id = $this->insert($product);
            return $this->find(array('product_id' => $id));
        }
        $existing = self::find(array('product_id' => $product->getProductId()));
        if($existing){
            $where = array('product_id' => $product->getProductId());
            return $this->update($dbProduct, $where);
        } else {
            $id = $this->insert($dbProduct);
            return $this->find(array('product_id' => $id));
        }
    }

    public function addOption($productId, $optionId)
    {
        $table = 'catalog_product_option';
        $row = array('product_id' => $productId, 'option_id' => $optionId);
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }

    public function addImage($productId, $imageId)
    {
        $table = 'catalog_product_image';
        $row = array('product_id' => $productId, 'image_id' => $imageId);
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->query($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }
}
