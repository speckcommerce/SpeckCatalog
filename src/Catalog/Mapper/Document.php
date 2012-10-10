<?php

namespace Catalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $relationalModel = 'Catalog\Model\Document\Relational';
    protected $dbModel = 'Catalog\Model\Document';
    protected $key = array('product_id', 'document_id');

    public function getDocuments($productId)
    {
        $select = $this->getSelect()
            ->from($this->getTableName())
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function persist($document)
    {
        $document = $this->getDbModel($document);
        if(null === $document->getDocumentId()){
            $id = $this->insert($document);
            return $document->setDocumentId($id);
        } elseif($this->find($document->getDocumentId())) {
            $where = array('document_id' => $document->getDocumentId());
            return $this->update($document, $where);
        }
    }
}
