<?php

namespace Catalog\Service;

class ProductService extends ServiceAbstract
{
    protected $optionService;
    protected $productUomService;
    protected $companyService;
    protected $specService;
    protected $documentService;
    protected $imageService;
    
    public function populateModel($product){
        if($product){
            $productId = $product->getProductId();
            $product->setOptions($this->getOptionService()->getOptionsByProductId($productId));
            $product->setUoms($this->getProductUomService()->getProductUomsByParentProductId($productId));
            $product->setCompanies($this->getCompanyService()->getAll());
            $product->setSpecs($this->getSpecService()->getByProductId($productId));
            $product->setDocuments($this->getDocumentService()->getDocumentsByProductId($productId));
            $product->setImages($this->getImageService()->getImagesByProductId($productId));
            return $product;
        }
    }

    public function getProductsByCategoryId($categoryId)
    {
        return $this->getModelMapper()->getProductsByCategoryId($categoryId);
    }

    public function linkParentCategory($categoryId, $productId){
        return $this->getModelMapper()->linkParentCategory($categoryId, $productId);
    } 

    public function getOptionService()
    {
        return $this->optionService;
    }

    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }
 
    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
 
    public function getCompanyService()
    {
        return $this->companyService;
    }

    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }

    public function getSpecService()
    {
        return $this->specService;
    }

    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }

    public function getDocumentService()
    {
        return $this->documentService;
    }

    public function setDocumentService($documentService)
    {
        $this->documentService = $documentService;
        return $this;
    }

    public function getImageService()
    {
        return $this->imageService;
    }

    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }
}
