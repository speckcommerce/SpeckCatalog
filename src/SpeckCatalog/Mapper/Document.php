<?php

namespace SpeckCatalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $relationalModel = 'SpeckCatalog\Model\Document\Relational';
    protected $dbModel = 'SpeckCatalog\Model\Document';

    public function find(array $data)
    {
        $where = array('document_id' => $data['document_id']);
        return parent::find($where);
    }

    public function getDocuments($productId)
    {
        $select = $this->getSelect()
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }
}
