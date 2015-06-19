<?php

namespace SpeckCatalog\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    protected $catalogPartialDir        = '/speck-catalog/catalog/partial/';
    protected $catalogManagerPartialDir = '/speck-catalog/catalog-manager/partial/';

    protected $productImagePath         = '/media/product-image';
    protected $productImageUpload       = '/public/media/product-image';

    protected $productDocumentPath      = '/media/product-document';
    protected $productDocumentUpload    = '/public/media/product-document';

    protected $categoryImagePath        = '/media/category-image';
    protected $categoryImageUpload      = '/public/media/category-image';

    protected $optionImagePath          = '/media/option-image';
    protected $optionImageUpload        = '/public/media/option-image';

    public function getProductDocumentPath()
    {
        return $this->productDocumentPath;
    }

    public function setProductDocumentPath($productDocumentPath)
    {
        $this->productDocumentPath = $productDocumentPath;
    }

    public function getProductImagePath()
    {
        return $this->productImagePath;
    }

    public function setProductImagePath($productImagePath)
    {
        $this->productImagePath = $productImagePath;
    }

    public function getCategoryImagePath()
    {
        return $this->categoryImagePath;
    }

    public function setCategoryImagePath($categoryImagePath)
    {
        $this->categoryImagePath = $categoryImagePath;
    }

    public function getOptionImagePath()
    {
        return $this->optionImagePath;
    }

    public function setOptionImagePath($optionImagePath)
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

    /**
     * @return catalogPartialDir
     */
    public function getCatalogPartialDir()
    {
        return $this->catalogPartialDir;
    }

    /**
     * @param $catalogPartialDir
     * @return self
     */
    public function setCatalogPartialDir($partialDir)
    {
        $this->catalogPartialDir = $partialDir;
        return $this;
    }

    /**
     * @return catalogManagerPartialDir
     */
    public function getCatalogManagerPartialDir()
    {
        return $this->catalogManagerPartialDir;
    }

    /**
     * @param $catalogManagerPartialDir
     * @return self
     */
    public function setCatalogManagerPartialDir($partialDir)
    {
        $this->catalogManagerPartialDir = $partialDir;
        return $this;
    }
}
