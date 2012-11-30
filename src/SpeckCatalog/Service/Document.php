<?php

namespace SpeckCatalog\Service;

class Document extends AbstractService
{
    protected $entityMapper = 'speckcatalog_document_mapper';

    public function getDocuments($productId)
    {
        return $this->getEntityMapper()->getDocuments($productId);
    }

    public function addLinker($parentName, $parentId, $image)
    {
        return $this->getEntityMapper()->addLinker($parentName, $parentId, $image);
    }
}
