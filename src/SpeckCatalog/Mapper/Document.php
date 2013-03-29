<?php

namespace SpeckCatalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $model = 'SpeckCatalog\Model\Document\Relational';
    protected $hydrator = 'SpeckCatalog\Mapper\Hydrator\Document';

    public function getByProductId($productId)
    {
        $select = $this->getSelect();
        $select->where(array('product_id' => $productId));
        return $this->selectManyModels($select);
    }
}
