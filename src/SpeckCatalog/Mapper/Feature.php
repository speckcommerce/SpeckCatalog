<?php

namespace SpeckCatalog\Mapper;

class Feature extends AbstractMapper
{
    protected $tableName = 'catalog_product_feature';
    protected $model = 'SpeckCatalog\Model\Feature\Relational';

    public function getByProductId($productId)
    {
        $select = $this->getSelect()
            ->where(array('product_id' => $productId));
        return $this->selectManyModels($select);
    }
}
