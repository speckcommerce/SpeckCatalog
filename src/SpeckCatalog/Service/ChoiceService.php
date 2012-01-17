<?php

namespace SpeckCatalog\Service;

class ChoiceService
{
    protected $choiceMapper;
    protected $productMapper;
    
    public function getChoiceById($id)
    {
        return $this->choiceMapper->getChoiceById($id);
    }     
    
    public function getChoicesByParentOptionId($id)
    {
        $choices = $this->choiceMapper->getChoicesByParentOptionId($id);
        $return = array();
        foreach ($choices as $choice){
            $return[] = $this->populateChoice($choice);
        }
        return $return;
    }

    public function populateChoice($choice)
    {
        $product = $this->productMapper->getProductById($choice->getProductId());
        $choice->setProduct($product);
        return $choice;
    }
    
    public function newOptionChoice($optionId)
    {
        $choice = $this->choiceMapper->newModel();
        $choice->setParentOptionId($optionId);
        $product = $this->productMapper->newModel('shell');
        $choice->setProductId($product->getProductId());
        $this->choiceMapper->update($choice);
        $choice->setProduct($product);
        return $choice;
    }

    public function updateModelFromArray($arr)
    {
        $choice = $this->choiceMapper->instantiateModel($arr);
        return $this->choiceMapper->update($choice)->toArray();
    }  
    
    public function getModelsBySearchData($string)
    {
        return $this->optionMapper->getModelsBySearchData($string);
    }
    
    public function linkParent($productId, $optionId)
    {
        $this->optionMapper->linkOptionToProduct($productId, $optionId);
    }    

    public function add($option)
    {
        $this->optionMapper->add($option);
    }

    public function update($option)
    {
        $this->optionMapper->update($option);
    }

    public function getChoiceMapper()
    {
        return $this->choiceMapper;
    }

    public function setChoiceMapper($choiceMapper)
    {
        $this->choiceMapper = $choiceMapper;
        return $this;
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
}
