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
    protected $choiceService;
    
    public function _populateModel($product)
    {
        
        $productId = $product->getProductId();

        
        $product->setParentChoices($this->getChoiceService()->getChoicesByChildProductId($productId))

                ->setOptions($this->getOptionService()->getOptionsByProductId($productId))
                ->setUoms($this->getProductUomService()->getProductUomsByParentProductId($productId))
                ->setManufacturer($this->getCompanyService()->getById($product->getManufacturerCompanyId()))
                ->setCompanies($this->getCompanyService()->getAll())
                ->setSpecs($this->getSpecService()->getByProductId($productId))
                ->setDocuments($this->getDocumentService()->getDocumentsByProductId($productId))
                ->setImages($this->getImageService()->getImagesByProductId($productId));

        return $product;
    }

    public function getProductsByChildOptionId($optionId)
    {
        return $this->getModelMapper()->getProductsByChildOptionId($optionId);
    }

    public function getProductsByCategoryId($categoryId)
    {
        return $this->getModelMapper()->getProductsByCategoryId($categoryId);
    }

    public function linkParentCategory($categoryId, $productId)
    {
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

    public function getChoiceService()
    {
        return $this->choiceService;
    }

    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
}
