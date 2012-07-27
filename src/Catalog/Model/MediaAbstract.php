<?php

namespace Catalog\Model;

abstract class MediaAbstract extends LinkedModelAbstract
{
    protected $mediaId;
    /**
     * label
     *
     * @var string
     * @access protected
     */
    protected $label;

    /**
     * fileName
     *
     * @var string
     * @access protected
     */
    protected $fileName;

    /**
     * mediaType
     *
     * @var string
     * @access protected
     */
    protected $mediaType;

    /**
     * baseUrl
     *
     * @var string
     * @access protected
     */
    protected $baseUrl;

    public function __toString()
    {
        return '';
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
        if ($this->getBaseUrl()
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

 /**
  * Get mediaId.
  *
  * @return mediaId.
  */
 function getMediaId()
 {
     return $this->mediaId;
 }

 /**
  * Set mediaId.
  *
  * @param mediaId the value to set.
  */
 function setMediaId($mediaId)
 {
     $this->mediaId = $mediaId;
 }
    public function getId()
    {
        return $this->mediaId;
    }
    public function setId($id)
    {
        return $this->setMediaId($id);
    }
}
