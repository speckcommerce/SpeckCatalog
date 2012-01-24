<?php

namespace SpeckCatalog\Service;

class ProductService extends ServiceAbstract
{
    protected $optionService;
    protected $productUomService;
    protected $companyService;
    
    public function populateModel($product){
        if($product){
            $product->setOptions($this->getOptionService()->getOptionsByProductId($product->getProductId()));
            $product->setUoms($this->getProductUomService()->getProductUomsByParentProductId($product->getProductId()));
            $product->setCompanies($this->getCompanyService()->getAll());
            return $product;
        }
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
}
