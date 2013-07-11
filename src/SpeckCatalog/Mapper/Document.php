<?php

namespace SpeckCatalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $model = 'SpeckCatalog\Model\Document\Relational';
    protected $tableKeyFields = array('document_id');
    protected $tableFields = array('document_id', 'product_id', 'sort_weight', 'file_name', 'label');

    public function getByProductId($productId)
    {
        $select = $this->getSelect();
        $select->where(array('product_id' => $productId));
        return $this->selectManyModels($select);
    }
}
