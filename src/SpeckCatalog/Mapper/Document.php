<?php

namespace Catalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $relationalModel = 'Catalog\Model\Document\Relational';
    protected $dbModel = 'Catalog\Model\Document';

    public function find(array $data)
    {
        $where = array('document_id' => $data['document_id']);
        $select = $this->getSelect()
            ->where($where);
        return $this->selectOne($select);
    }

    public function getDocuments($productId)
    {
        $select = $this->getSelect()
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }
}
