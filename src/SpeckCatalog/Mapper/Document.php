<?php

namespace SpeckCatalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $model = 'SpeckCatalog\Model\Document\Relational';

    public function getByProductId($productId)
    {
        $select = $this->getSelect();
        $select->where(array('product_id' => $productId));
        return $this->selectManyModels($select);
    }
}
