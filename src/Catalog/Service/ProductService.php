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
        $productId = $product->getRecordId();
        
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
        if(null === $this->optionService){
            $this->optionService = $this->getServiceManager()->get('catalog_option_service');
        }
        return $this->optionService;    
    }
 
    public function getProductUomService()
    {
        if(null === $this->productUomService){
            $this->productUomService = $this->getServiceManager()->get('catalog_product_uom_service');
        }
        return $this->productUomService;   
    }
 
    public function getCompanyService()
    {
        if(null === $this->companyService){
            $this->companyService = $this->getServiceManager()->get('catalog_company_service');
        }
        return $this->companyService;  
    }

    public function getSpecService()
    {
        if(null === $this->specService){
            $this->specService = $this->getServiceManager()->get('catalog_spec_service');
        }
        return $this->specService; 
    }

    public function getDocumentService()
    {
        if(null === $this->documentService){
            $this->documentService = $this->getServiceManager()->get('catalog_document_service');
        }
        return $this->documentService; 
    }

    public function getImageService()
    {
        if(null === $this->imageService){
            $this->imageService = $this->getServiceManager()->get('catalog_image_service');
        }
        return $this->imageService; 
    }

    public function getChoiceService()
    {
        if(null === $this->choiceService){
            $this->choiceService = $this->getServiceManager()->get('catalog_choice_service');
        }
        return $this->choiceService;  
    }
 
    public function setOptionService($optionService)
    {
        $this->optionService = $optionService;
        return $this;
    }
 
    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
 
    public function setCompanyService($companyService)
    {
        $this->companyService = $companyService;
        return $this;
    }
 
    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }
 
    public function setDocumentService($documentService)
    {
        $this->documentService = $documentService;
        return $this;
    }
 
    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }
 
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }

    public function getModelMapper()
    {
        if(null === $this->modelMapper){
            $this->modelMapper = $this->getServiceManager()->get('catalog_product_mapper');
        }
        return $this->modelMapper;         
    }
}
