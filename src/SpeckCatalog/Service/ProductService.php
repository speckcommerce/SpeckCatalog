<?php

namespace SpeckCatalog\Service;

class ProductService
{
    protected $productMapper;
    protected $optionService;
    
    public function getProductById($id)
    {
        $product = $this->productMapper->getProductById($id);
        $options = $this->optionService->getOptionsByProductId($id);
        $product->setOptions($options);
        return $product;
    }

    public function updateModelFromArray($arr)
    {
        $product = $this->productMapper->instantiateModel($arr);
        return $this->productMapper->update($product)->toArray();
    }

    public function newProduct($type)
    {
        return $this->productMapper->newModel($type);
    }    
    
    public function getModelsBySearchData($string)
    {
        return $this->productMapper->getModelsBySearchData($string);
    }    

    public function add($product)
    {
        $this->productMapper->add($product);
    }

    public function update($product)
    {
        $this->productMapper->update($product);
    
        if($product->hasOptions()){
            $this->optionMapper->linkOptionsToProduct($product->getProductId(), $product->getOptions);
        }
    }

    public function getProductMapper()
    {
        return $this->productMapper;
    }
 
    public function setProductMapper($productMapper)
    {
        $this->productMapper = $productMapper;
        return $this;
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
