<?php

namespace SpeckCatalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $model = 'SpeckCatalog\Model\Document\Relational';
    protected $tableKeyFields = ['document_id'];
    protected $tableFields = ['document_id', 'product_id', 'sort_weight', 'file_name', 'label'];

    public function getByProductId($productId)
    {
        $select = $this->getSelect();
        $select->where(['product_id' => $productId]);
        return $this->selectManyModels($select);
    }
}
