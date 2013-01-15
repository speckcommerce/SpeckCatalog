<?php

namespace SpeckCatalog\Mapper;

class Spec extends AbstractMapper
{
    protected $tableName = 'catalog_product_spec';
    protected $model = '\SpeckCatalog\Model\Spec\Relational';

    public function find(array $data)
    {
        $where = array('spec_id' => $data['spec_id']);
        return parent::find($where);
    }

    public function getByProductId($productId)
    {
        $where = array('product_id' => $productId);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectManyModels($select);
    }
}
