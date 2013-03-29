<?php

namespace SpeckCatalog\Mapper;

class Spec extends AbstractMapper
{
    protected $tableName      = 'catalog_product_spec';
    protected $model          = '\SpeckCatalog\Model\Spec\Relational';
    protected $tableFields    = array('spec_id', 'product_id', 'label', 'value');
    protected $tableKeyFields = array('spec_id');
    protected $hydrator = 'SpeckCatalog\Mapper\Hydrator\Spec';

    public function getByProductId($productId)
    {
        $where = array('product_id' => $productId);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectManyModels($select);
    }
}
