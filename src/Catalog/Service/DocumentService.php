<?php
namespace Catalog\Service;
class DocumentService extends ServiceAbstract
{
    public function newProductDocument($productId)
    {
        $document = $this->getModelMapper()->newModel();
        $this->linkParentProduct($productId, $document->getDocumentId());
        return $document;          
    }

    public function populateModel($model)
    {
        return $model;
    }

    public function linkParentProduct($productId, $documentId)
    {
        $this->getModelMapper()->linkParentProduct($productId, $documentId);
    }

    public function getByProductId($productId)
    {
        return $this->getModelMapper()->getByProductId($productId);
    }    
}
