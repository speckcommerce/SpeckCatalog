<?php

namespace Catalog\Entity;

class Media extends AbstractEntity
{
    protected $mediaId;
    protected $label;
    protected $fileName;

    /**
     * @return mediaId
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * @param $mediaId
     * @return self
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = (int) $mediaId;
        return $this;
    }

    /**
     * @return label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param $label
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $fileName
     * @return self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }
}
