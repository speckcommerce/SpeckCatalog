<?php

namespace Catalog\Mapper;

class Document extends AbstractMapper
{
    protected $tableName = 'catalog_product_document';
    protected $entityPrototype = 'Catalog\Entity\Document';
    protected $hydrator        = 'Catalog\Hydrator\Document';

    public function getDocuments($productId)
    {
        $select = $this->select()
            ->from($this->getTableName())
            ->where(array('product_id' => $productId));
        return $this->selectMany($select);
    }

    public function persist($document)
    {
        if(null === $document->getDocumentId()){
            $id = $this->insert($document);
            return $document->setDocumentId($id);
        } elseif($this->find($document->getDocumentId())) {
            $where = array('document_id' => $document->getDocumentId());
            return $this->update($document, $where);
        }
    }
}
