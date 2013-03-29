<?php

namespace SpeckCatalog\Mapper;

class ProductUom extends AbstractMapper
{
    protected $tableName = 'catalog_product_uom';
    protected $model = '\SpeckCatalog\Model\ProductUom\Relational';
    protected $tableKeyFields = array('product_id', 'uom_code', 'quantity');
    protected $tableFields = array('product_id', 'uom_code', 'quantity', 'price', 'retail', 'enabled', 'sort_weight');
    protected $hydrator = 'SpeckCatalog\Mapper\Hydrator\ProductUom';

    public function getByProductId($productId)
    {
        $select = $this->getSelect()
            ->where(array('product_id' => $productId))
            ->order('quantity');
        return $this->selectManyModels($select);
    }
}
