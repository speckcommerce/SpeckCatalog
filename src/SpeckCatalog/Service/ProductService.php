<?php

namespace SpeckCatalog\Service;

class ProductService extends ServiceAbstract
{
    protected $optionService;
    protected $productUomService;
    
    public function populateModel($product){
        $product->setOptions($this->getOptionService()->getOptionsByProductId($product->getProductId()));
        $product->setUoms($this->getProductUomService()->getProductUomsByParentProductId($product->getProductId()));
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
 
    public function getProductUomService()
    {
        return $this->productUomService;
    }

    public function setProductUomService($productUomService)
    {
        $this->productUomService = $productUomService;
        return $this;
    }
}
