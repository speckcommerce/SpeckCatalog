<?php
namespace Catalog\Service;
class DocumentService extends MediaServiceAbstract
{
    public function newProductDocument($productId)
    {
        return $this->getModelMapper()->newModel();
    }

    public function linkParentProduct($productId, $documentId)
    {
        $this->getModelMapper()->linkParentProduct($productId, $documentId);
    }

    public function getDocumentsByProductId($productId)
    {
        return $this->getModelMapper()->getDocumentsByProductId($productId);
    }    
}
