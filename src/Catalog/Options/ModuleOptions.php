<?php

namespace Catalog\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $productDocumentPath = '/public/speck-catalog/media/document';
    protected $productImagePath    = '/public/speck-catalog/media/product_image';
    protected $categoryImagePath   = '/public/speck-catalog/media/category_image';
    protected $optionImagePath     = '/public/speck-catalog/media/option_image';

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
}


