<?php

namespace SpeckCatalog\Service;

class ProductService extends ServiceAbstract
{
    protected $optionService;
    
    public function populateModel($product){
        $options = $this->optionService->getOptionsByProductId($product->getProductId());
        $product->setOptions($options);
        return $product;
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
}
