<?php

namespace Catalog\Entity;

class Image extends AbstractEntity
{
    protected $imageId;
    protected $label;
    protected $fileName;
    protected $parentId;

    //non-db fields
    protected $parentType;

    /**
     * @return imageId
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @param $imageId
     * @return self
     */
    public function setImageId($imageId)
    {
        $this->imageId = (int) $imageId;
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

    /**
     * @return parentType
     */
    public function getParentType()
    {
        return $this->parentType;
    }

    /**
     * @param $parentType
     * @return self
     */
    public function setParentType($parentType)
    {
        $this->parentType = $parentType;
        return $this;
    }

    /**
     * @return parentId
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param $parentId
     * @return self
     */
    public function setParentId($parentId)
    {
        $this->parentId = (int) $parentId;
        return $this;
    }
}
