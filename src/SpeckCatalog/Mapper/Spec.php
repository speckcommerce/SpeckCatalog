<?php

namespace Catalog\Mapper;

class Spec extends AbstractMapper
{
    protected $tableName = 'catalog_product_spec';
    protected $relationalModel = '\Catalog\Model\Spec\Relational';
    protected $dbModel = '\Catalog\Model\Spec';

    public function find(array $data)
    {
        $where = array('spec_id' => $data['spec_id']);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectOne($select);
    }

    public function getByProductId($productId)
    {
        $where = array('product_id' => $productId);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectMany($select);
    }
}
