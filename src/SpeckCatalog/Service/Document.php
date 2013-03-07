<?php

namespace SpeckCatalog\Service;

class Document extends AbstractService
{
    protected $entityMapper = 'speckcatalog_document_mapper';

    public function getDocuments($productId)
    {
        return $this->getEntityMapper()->getByProductId($productId);
    }
}
