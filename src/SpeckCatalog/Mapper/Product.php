<?php

namespace SpeckCatalog\Mapper;

class Product extends AbstractMapper
{
    protected $tableName = 'catalog_product';
    protected $relationalModel = '\SpeckCatalog\Model\Product\Relational';
    protected $dbModel = '\SpeckCatalog\Model\Product';
    protected $hydrator = 'SpeckCatalog\Hydrator\Product';
    protected $key = array('product_id');
    protected $dbFields = array('product_id', 'name', 'description', 'product_type_id', 'item_number', 'manufacturer_id');

    public function find(array $data)
    {
        $where = array('product_id' => $data['product_id']);
        return parent::find($where);
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

    public function addOption($productId, $optionId)
    {
        $table = 'catalog_product_option';
        $row = array('product_id' => $productId, 'option_id' => $optionId);
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->queryOne($select);
        if (false === $result) {
            $this->insert($row, $table);
        }
    }

    public function removeOption($productId, $optionId)
    {
        $table = 'catalog_product_option';
        $row = array('product_id' => $productId, 'option_id' => $optionId);
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->queryOne($select);
        $return = false;
        if ($result) {
            $resp = $this->delete($row, $table);
            $return = true;
        }
        return $return;
    }

    public function sortOptions($productId, $order)
    {
        $table = 'catalog_product_option';
        foreach ($order as $i => $optionId) {
            $where = array('product_id' => $productId, 'option_id' => $optionId);
            $select = $this->getSelect($table)->where($where);
            $row = $this->queryOne($select);
            $row['sort_weight'] = $i;
            $this->update($row, $where, $table);
        }
    }
}
