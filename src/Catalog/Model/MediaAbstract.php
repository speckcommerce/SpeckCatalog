<?php
namespace Catalog\Model;
abstract class MediaAbstract extends ModelAbstract
{
    protected $label;
    protected $fileName;
    protected $mediaType;
    protected $baseUrl;

    protected $sortWeight;
    protected $linkerId;

    public function __toString()
    {
        return '';
    }

    public function getMediaId()
    {
        return (int) $this->mediaId;
    }

    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    public function getFullPath()
    {
        if($this->getBaseUrl() 
            && $this->getFileName()
            && @fopen($this->getBaseUrl() . $this->getFileName(),'r') 
        ){
            return $this->getBaseUrl() . $this->getFileName();
        }else{
            return $this->noFile();
        }
    }
    
    public function noFile()
    {
        return '';
    }  
 
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
 
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function getSortWeight()
    {
        return $this->sortWeight;
    }

    public function setSortWeight($sortWeight)
    {
        $this->sortWeight = $sortWeight;
        return $this;
    }
 
    /**
     * Get linkerId.
     *
     * @return linkerId
     */
    public function getLinkerId()
    {
        return $this->linkerId;
    }
 
    /**
     * Set linkerId.
     *
     * @param $linkerId the value to be set
     */
    public function setLinkerId($linkerId)
    {
        $this->linkerId = $linkerId;
        return $this;
    }
}
