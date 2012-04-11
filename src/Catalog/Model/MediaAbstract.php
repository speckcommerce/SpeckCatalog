<?php
namespace Catalog\Model;
abstract class MediaAbstract extends ModelAbstract
{
    protected $mediaId;
    protected $label;
    protected $fileName;
    protected $mediaType;

    public function getId()
    {
        return $this->getMediaId();
    }
    
    public function setId($id)
    {
        return $this->setMediaId( (int) $id);
    }

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
}
