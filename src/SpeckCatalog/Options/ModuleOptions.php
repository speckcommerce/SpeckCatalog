<?php

namespace SpeckCatalog\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $productImagePath             = '/assets/speck-catalog/media/product-image';
    protected $productImageUpload    = '/public/assets/speck-catalog/media/product-image';

    protected $productDocumentPath          = '/assets/speck-catalog/media/product-document';
    protected $productDocumentUpload = '/public/assets/speck-catalog/media/product-document';

    protected $categoryImagePath            = '/assets/speck-catalog/media/category-image';
    protected $categoryImageUpload   = '/public/assets/speck-catalog/media/category-image';

    protected $optionImagePath              = '/assets/speck-catalog/media/option-image';
    protected $optionImageUpload     = '/public/assets/speck-catalog/media/option-image';

    function getProductDocumentPath()
    {
        return $this->productDocumentPath;
    }

    function setProductDocumentPath($productDocumentPath)
    {
        $this->productDocumentPath = $productDocumentPath;
    }

    function getProductImagePath()
    {
        return $this->productImagePath;
    }

    function setProductImagePath($productImagePath)
    {
        $this->productImagePath = $productImagePath;
    }

    function getCategoryImagePath()
    {
        return $this->categoryImagePath;
    }

    function setCategoryImagePath($categoryImagePath)
    {
        $this->categoryImagePath = $categoryImagePath;
    }

    function getOptionImagePath()
    {
        return $this->optionImagePath;
    }

    function setOptionImagePath($optionImagePath)
    {
        $this->optionImagePath = $optionImagePath;
    }

    public function getProductImageUpload()
    {
        return $this->productImageUpload;
    }

    public function setProductImageUpload($productImageUpload)
    {
        $this->productImageUpload = $productImageUpload;
        return $this;
    }

    /**
     * @return productDocumentUpload
     */
    public function getProductDocumentUpload()
    {
        return $this->productDocumentUpload;
    }

    /**
     * @param $productDocumentUpload
     * @return self
     */
    public function setProductDocumentUpload($productDocumentUpload)
    {
        $this->productDocumentUpload = $productDocumentUpload;
        return $this;
    }

    /**
     * @return categoryImageUpload
     */
    public function getCategoryImageUpload()
    {
        return $this->categoryImageUpload;
    }

    /**
     * @param $categoryImageUpload
     * @return self
     */
    public function setCategoryImageUpload($categoryImageUpload)
    {
        $this->categoryImageUpload = $categoryImageUpload;
        return $this;
    }

    /**
     * @return optionImageUpload
     */
    public function getOptionImageUpload()
    {
        return $this->optionImageUpload;
    }

    /**
     * @param $optionImageUpload
     * @return self
     */
    public function setOptionImageUpload($optionImageUpload)
    {
        $this->optionImageUpload = $optionImageUpload;
        return $this;
    }
}


