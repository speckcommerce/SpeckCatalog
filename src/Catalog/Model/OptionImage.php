<?php

namespace Catalog\Model;

class OptionImage extends AbstractModel
{
    protected $imageId;
    protected $label;
    protected $fileName;
    protected $optionId;

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
        $this->imageId = $imageId;
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
     * @return optionId
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @param $optionId
     * @return self
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }
}
