<?php

namespace Catalog\Service;

class ProductService extends ServiceAbstract
{
    protected $optionService;
    protected $productUomService;
    protected $companyService;
    protected $specService;
    
    public function populateModel($product){
        if($product){
            $product->setOptions($this->getOptionService()->getOptionsByProductId($product->getProductId()));
            $product->setUoms($this->getProductUomService()->getProductUomsByParentProductId($product->getProductId()));
            $product->setCompanies($this->getCompanyService()->getAll());
            $product->setSpecs($this->getSpecService()->getByProductId($product->getProductId()));
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
 
    /**
     * Get specService.
     *
     * @return specService
     */
    public function getSpecService()
    {
        return $this->specService;
    }
 
    /**
     * Set specService.
     *
     * @param $specService the value to be set
     */
    public function setSpecService($specService)
    {
        $this->specService = $specService;
        return $this;
    }
}
