<?php

namespace SpeckCatalog\Mapper\Hydrator;

use SpeckCatalog\Model\Document as Model;
use Zend\Stdlib\Hydrator\ClassMethods;

class Document extends ClassMethods
{
    public function extract(Model $model)
    {
        $data['document_id'] = $document->getDocumentId();
        $data['product_id']  = $document->getProductId();
        $data['sort_weight'] = $document->getSortWeight();
        $data['file_name']   = $document->getFileName();
        $data['label']       = $document->getLabel();

        return $data;
    }
}
