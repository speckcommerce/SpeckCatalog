<?php
namespace Catalog\Model;
class Image extends MediaAbstract
{
    public function setImageId($id)
    {
        return $this->setMediaId($id);
    }
    
    public function getImageId()
    {
        return $this->getMediaId();
    }     
}
