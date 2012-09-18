<?php

namespace Catalog\Service;

class Document extends AbstractService
{
    protected $entityMapper = 'catalog_document_mapper';

    public function getDocuments($type, $id)
    {
        return $this->getEntityMapper()->getDocuments($type, $id);
    }

    public function addLinker($parentName, $parentId, $image)
    {
        return $this->getEntityMapper()->addLinker($parentName, $parentId, $image);
    }
}
