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
        $documents = $this->getModelMapper()->getDocumentsByProductId($productId);
        foreach($documents as $i => $document){
            $documents[$i] = $this->populateModel($document);
        }
        return $documents;
    }    
}
