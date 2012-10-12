<?php

namespace Catalog\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $productImagePath    = '/assets/speck-catalog/media/product-image';
    protected $productImageUpload  = '/public/assets/speck-catalog/media/product-image';

    protected $productDocumentPath = '/public/assets/speck-catalog/media/document';
    protected $categoryImagePath   = '/public/assets/speck-catalog/media/category-image';
    protected $optionImagePath     = '/public/assets/speck-catalog/media/option-image';

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
}


