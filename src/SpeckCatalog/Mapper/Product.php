<?php

namespace SpeckCatalog\Mapper;

use \Zend\Db\Sql\Predicate;
use \Zend\Db\Sql\Where;

class Product extends AbstractMapper
{
    protected $tableName = 'catalog_product';

    protected $model = '\SpeckCatalog\Model\Product\Relational';

    protected $tableKeyFields = ['product_id'];

    protected $tableFields = [
        'product_id', 'name', 'description', 'product_type_id',
        'item_number', 'manufacturer_id', 'enabled'
    ];

    protected $categoryLinkerFields = [
        'category_id'     => 'category_id',
        'cpc_product_id'  => 'product_id',
        'website_id'      => 'website_id',
        'image_file_name' => 'image_file_name',
    ];

    public function search(array $params)
    {
        $where = new Where;

        if (isset($params['product_type_id'])) {
            $where->equalTo('product_type_id', $params['product_type_id']);
        }
        if (isset($params['query']) && trim($params['query'])) {
            $where->like('name', "%{$params['query']}%");
        } else {
            //todo: make this less hacky
            return [];
        }
        $select = $this->getSelect()->where($where);

        return $this->selectManyModels($select);
    }

    public function find(array $data)
    {
        $table  = $this->getTableName();
        if (isset($data['product_id'])) {
            $where  = ['product_id' => $data['product_id']];
        } else {
            $where = ['item_number' => $data['item_number']];
        }
        $select = $this->getSelect()
            ->where($where);
        if ($this->enabledOnly()) {
            $select->where(['enabled' => 1]);
        }
        return $this->selectOneModel($select);
    }


    public function getAllProductsInCategories()
    {
        $table      = $this->getTableName();
        $linker     = 'catalog_category_product';
        $joinString = $linker . '.product_id      = ' . $table . '.product_id';
        $predicate  = new Predicate\Predicate();
        $predicate->isNotNull('category_id');

        $select = $this->getSelect()
            ->join($linker, $joinString, $this->getCategoryLinkerFields())
            ->where([$predicate]);
        if ($this->enabledOnly()) {
            $select->where(['enabled' => 1]);
        }
        return $this->selectManyModels($select);
    }

    public function getByCategoryId($categoryId, $siteId = 1)
    {
        $table      = $this->getTableName();
        $linker     = 'catalog_category_product';
        $joinString = $linker . '.product_id = ' . $table . '.product_id';
        $where      = [
            'category_id' => $categoryId,
            'website_id' => $siteId
        ];

        $select = $this->getSelect()
            ->join($linker, $joinString, $this->getCategoryLinkerFields())
            ->where($where);
        if ($this->enabledOnly()) {
            $select->where(['enabled' => 1]);
        }
        return $this->selectManyModels($select);
    }

    public function addOption($productId, $optionId)
    {
        $table  = 'catalog_product_option';
        $row    = [
            'product_id' => $productId,
            'option_id'  => $optionId
        ];
        $select = $this->getSelect($table)
            ->where($row);
        $linker = $this->selectOne($select);
        if (!$linker) {
            $this->insert($row, $table);
            return true;
        }
        return false;
    }

    public function getProductsById(array $productIds = [])
    {
        $wheres = [];
        foreach ($productIds as $productId) {
            $predicate = new Predicate\Predicate();
            $wheres[] = $predicate->equalTo('product_id', $productId);
        }
        $select = $this->getSelect()->where($wheres, Predicate\PredicateSet::OP_OR);
        if ($this->enabledOnly()) {
            $select->where(['enabled' => 1]);
        }

        return $this->selectManyModels($select);
    }

    public function removeOption($productId, $optionId)
    {
        $table  = 'catalog_product_option';
        $row    = [
            'product_id' => $productId,
            'option_id'  => $optionId
        ];
        $select = $this->getSelect($table)
            ->where($row);
        $result = $this->selectOne($select);
        if ($result) {
            $resp = $this->delete($row, $table);
            return 'true';
        }
        return 'false';
    }

    public function removeBuilder($productId, $builderProductId)
    {
        $c_b_p = 'catalog_builder_product';
        $c_p_o = 'catalog_product_option';

        $select = $this->getSelect($c_b_p)
            ->columns(['product_id', 'choice_id', 'option_id'])
            ->join($c_p_o, $c_p_o.'.option_id='.$c_b_p.'.option_id', [])
            ->where([
                $c_b_p.'.product_id' => $builderProductId,
                $c_p_o.'.product_id' => $productId,
            ]);
        $rows = $this->selectMany($select);

        foreach ($rows as $row) {
            $this->delete($row, $c_b_p);
        }

        return true;
    }

    public function removeSpec($productId, $specId)
    {
        $table = 'catalog_product_spec';
        $row = [
            'product_id' => $productId,
            'spec_id'    => $specId
        ];
        $select = $this->getSelect($table)
            ->where($row);

        $result = $this->selectOne($select);
        $return = false;

        if ($result) {
            $this->delete($row, $table);
            $return = true;
        }
        return $return;
    }

    public function sortOptions($productId, array $order)
    {
        $table = 'catalog_product_option';
        foreach ($order as $i => $optionId) {
            $where = [
                'product_id' => $productId,
                'option_id'  => $optionId
            ];
            $select = $this->getSelect($table)->where($where);
            $row = $this->selectOne($select);
            $row['sort_weight'] = $i;
            $this->update($row, $where, $table);
        }
    }

    public function getCategoryLinkerFields()
    {
        return $this->categoryLinkerFields;
    }

    public function setCategoryLinkerFields($categoryLinkerFields)
    {
        $this->categoryLinkerFields = $categoryLinkerFields;
        return $this;
    }
}
