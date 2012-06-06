<?php
namespace Catalog\Service;
class DocumentService extends MediaServiceAbstract
{
    public function getDocumentsByProductId($productId)
    {
        $documents = $this->getModelMapper()->getMediaByProductId($productId);
        foreach($documents as $i => $document){
            $documents[$i] = $this->populateModel($document);
        }
        return $documents;
    }    

    public function updateSortOrder($parent, $order)
    {
        $this->getModelMapper()->updateProductDocumentSortOrder($order);
    }   

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_document_mapper');
        }
        return $this->modelMapper;         
    }

}
