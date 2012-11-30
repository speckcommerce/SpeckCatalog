<?php

namespace SpeckCatalog\Model;

class ProductImage extends AbstractModel
{
    protected $imageId;
    protected $label;
    protected $fileName;
    protected $productId;

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
     * @return productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param $productId
     * @return self
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
}
