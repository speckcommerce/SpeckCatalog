<?php
namespace Catalog\Service;
class DocumentService extends MediaServiceAbstract
{
    public function newProductDocument($productId)
    {
        return $this->getModelMapper()->newModel();
    }

    public function getDocumentsByProductId($productId)
    {
        return $this->getModelMapper()->getDocumentsByProductId($productId);
    }    
}
