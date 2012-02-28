<?php

namespace Catalog\Service;

class ProductService extends ServiceAbstract
{
    protected $optionService;
    protected $productUomService;
    protected $companyService;
    protected $choiceService;
    
    public function populateModel($product){
        if($product){
            $product->setOptions($this->getOptionService()->getOptionsByProductId($product->getProductId()));
            $product->setUoms($this->getProductUomService()->getProductUomsByParentProductId($product->getProductId()));
            $product->setCompanies($this->getCompanyService()->getAll());
            return $product;
        }
    } 

    //convenience, so that the model linker service is a bit cleaner.
    public function linkParentChoice($choiceId, $productId)
    {
        $choiceService = $this->getChoiceService();
        $choice = $choiceService->getById($choiceId);
        $choice->setProductId($productId);
        $choiceService->update($choice);
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
     * Get choiceService.
     *
     * @return choiceService
     */
    public function getChoiceService()
    {
        return $this->choiceService;
    }
 
    /**
     * Set choiceService.
     *
     * @param $choiceService the value to be set
     */
    public function setChoiceService($choiceService)
    {
        $this->choiceService = $choiceService;
        return $this;
    }
}
