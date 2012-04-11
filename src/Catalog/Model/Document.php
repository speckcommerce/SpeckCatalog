<?php
namespace Catalog\Model;
class Document extends MediaAbstract
{
    public function setDocumentId($id)
    {
        return $this->setMediaId($id);
    }
    
    public function getDocumentId()
    {
        return $this->getMediaId();
    }
}
