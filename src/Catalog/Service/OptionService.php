<?php

namespace Catalog\Service;

class OptionService extends ServiceAbstract
{
    protected $choiceService;
    protected $productService;
    
    public function getOptionsByProductId($productId)
    {
        $options = $this->getModelMapper()->getOptionsByProductId($productId);
        $return = array();
        foreach($options as $option){
            $return[] = $this->populateModel($option);
        }
        return $return;
    }

    public function getOptionsByChoiceId($choiceId)
    {
        $options = $this->modelMapper->getOptionsByChoiceId($choiceId);
        $return = array();
        foreach($options as $option){
            $return[] = $this->populateModel($option);
        }
        return $return;
    }

    public function populateModel($option)
    {
        $parentProducts = $this->getProductService()->getProductsByChildOptionId($option->getOptionId());
        $option->setParentProducts($parentProducts);
        //$parentChoices = $this->getChoiceService()->getChoicesByChildOptionId($option->getOptionId());
        //$option->setParentChoices($parentChoices);
        
        $choices = $this->getChoiceService()->getChoicesByParentOptionId($option->getOptionId());
        if($choices){
            $option->setChoices($choices);
        }
        return $option;
    }
    
    public function newProductOption($productId)
    {
        $option = $this->newModel();
        $this->getModelMapper()->linkOptionToProduct($productId, $option->getOptionId());
        return $option;
    }

    public function newChoiceOption($choiceId){
        $option = $this->newModel();
        $this->getModelMapper()->linkOptionToChoice($choiceId, $option->getOptionId());
        return $option;    
    }

    public function updateSortOrder($parent, $order)
    {
        if('product' === $parent){
            $this->getModelMapper()->updateProductOptionSortOrder($order);
        }
        if('choice' === $parent){
            $this->getModelMapper()->updateChoiceOptionSortOrder($order);
        }
    }

    public function linkParentChoice($choiceId, $optionId)
    {
        return $this->getModelMapper()->linkOptionToChoice($choiceId, $optionId);
    }
    
    public function linkParentProduct($productId, $optionId)
    {
        return $this->getModelMapper()->linkOptionToProduct($productId, $optionId);
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

    public function getProductService()
    {
        return $this->productService;
    }

    public function setProductService($productService)
    {
        $this->productService = $productService;
        return $this;
    }
}
