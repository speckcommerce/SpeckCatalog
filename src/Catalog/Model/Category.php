<?php

namespace Catalog\Model;

class Category extends AbstractModel
{
    protected $categoryId;
    protected $name;
    protected $seoTitle;
    protected $descriptionHtml;
    protected $imageFileName;

    /**
     * @return categoryId
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param $categoryId
     * @return self
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return seoTitle
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * @param $seoTitle
     * @return self
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;
        return $this;
    }

    /**
     * @return imageFileName
     */
    public function getImageFileName()
    {
        return $this->imageFileName;
    }

    /**
     * @param $imageFileName
     * @return self
     */
    public function setImageFileName($imageFileName)
    {
        $this->imageFileName = $imageFileName;
        return $this;
    }

    /**
     * @return descriptionHtml
     */
    public function getDescriptionHtml()
    {
        return $this->descriptionHtml;
    }

    /**
     * @param $descriptionHtml
     * @return self
     */
    public function setDescriptionHtml($descriptionHtml)
    {
        $this->descriptionHtml = $descriptionHtml;
        return $this;
    }
}
