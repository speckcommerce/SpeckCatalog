<?php

namespace SpeckCatalog\Mapper;

class Spec extends AbstractMapper
{
    protected $tableName      = 'catalog_product_spec';
    protected $model          = '\SpeckCatalog\Model\Spec\Relational';
    protected $tableFields    = ['spec_id', 'product_id', 'label', 'value'];
    protected $tableKeyFields = ['spec_id'];

    public function getByProductId($productId)
    {
        $where = ['product_id' => $productId];
        $select = $this->getSelect()
            ->where($where);
        return $this->selectManyModels($select);
    }
}
